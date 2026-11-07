<?php

class ItemsController extends Controller
{
    private Item $item;
    private Category $category;

    public function __construct()
    {
        $this->requireLogin();
        $this->item     = $this->model('Item');
        $this->category = $this->model('Category');
    }

    private function resolveLimit(): int
    {
        $limit = (int) query_param('limit', '10');
        return in_array($limit, [5, 10, 20, 50, 100], true) ? $limit : 10;
    }

    public function index(): void
    {
        $this->authorize('items.view');

        $limit    = $this->resolveLimit();
        $page     = max(1, (int) query_param('page', '1'));
        $search   = query_param('search');
        $category = query_param('category');

        $this->view('items/index', [
            'title'        => 'Data Barang',
            'items'        => $this->item->paginate($limit, $page, $search, $category),
            'categories'   => $this->category->all(),
            'search'       => $search,
            'category'     => $category,
            'currentLimit' => $limit,
        ]);
    }

    public function create(): void
    {
        $this->authorize('items.create');

        $this->view('items/create', [
            'title'      => 'Tambah Barang',
            'code'       => $this->item->generateCode(),
            'categories' => $this->category->all(),
        ]);
    }

    public function store(): void
    {
        $this->authorize('items.create');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('items');

        $input = post_input();
        if (empty($input['code']) || empty($input['name'])) {
            $this->flash('danger', 'Kode dan nama barang wajib diisi.');
            $this->redirect('items/create');
        }
        if ((float) ($input['price'] ?? 0) < 0) {
            $this->flash('danger', 'Harga tidak boleh negatif.');
            $this->redirect('items/create');
        }

        $data = $this->payload($input);

        if (!empty($_FILES['photo']['name'])) {
            try {
                $data['photo'] = Upload::image($_FILES['photo']);
            } catch (RuntimeException $e) {
                $this->flash('danger', 'Foto gagal diunggah: ' . $e->getMessage());
                $this->redirect('items/create');
            }
        }

        try {
            $this->item->create($data);
        } catch (PDOException $e) {
            Upload::remove($data['photo'] ?? null);
            Logger::error('Create item failed', ['error' => $e->getMessage()]);
            $this->flash('danger', 'Barang gagal disimpan. Pastikan kode barang belum dipakai.');
            $this->redirect('items/create');
        }

        $this->logActivity('item.create', 'item', $this->item->lastInsertId(), $data['code'] . ' - ' . $data['name']);
        $this->flash('success', 'Barang berhasil ditambahkan.');
        $this->redirect('items');
    }

    public function edit($id = null): void
    {
        $this->authorize('items.update');

        $item = $id ? $this->item->find((int) $id) : null;
        if (!$item) {
            $this->flash('danger', 'Barang tidak ditemukan.');
            $this->redirect('items');
        }

        $this->view('items/edit', [
            'title'      => 'Edit Barang',
            'item'       => $item,
            'categories' => $this->category->all(),
        ]);
    }

    public function update(): void
    {
        $this->authorize('items.update');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('items');

        $input = post_input();
        $id = (int) ($input['id'] ?? 0);
        if ($id <= 0 || empty($input['code']) || empty($input['name'])) {
            $this->flash('danger', 'Data tidak valid.');
            $this->redirect('items');
        }
        if ((float) ($input['price'] ?? 0) < 0) {
            $this->flash('danger', 'Harga tidak boleh negatif.');
            $this->redirect('items/edit/' . $id);
        }

        $current = $this->item->find($id);
        if (!$current) {
            $this->flash('danger', 'Barang tidak ditemukan.');
            $this->redirect('items');
        }

        $data             = $this->payload($input);
        $data['photo']    = $current['photo'];
        $oldPhoto         = $current['photo'];
        $newPhoto         = null;

        if (!empty($_FILES['photo']['name'])) {
            try {
                $newPhoto      = Upload::image($_FILES['photo']);
                $data['photo'] = $newPhoto;
            } catch (RuntimeException $e) {
                $this->flash('danger', 'Foto gagal diunggah: ' . $e->getMessage());
                $this->redirect('items/edit/' . $id);
            }
        } elseif (!empty($input['remove_photo'])) {
            $data['photo'] = null;
        }

        try {
            $this->item->update($id, $data);
        } catch (PDOException $e) {
            Upload::remove($newPhoto);
            $this->flash('danger', 'Barang gagal diperbarui. Kode barang mungkin sudah dipakai.');
            $this->redirect('items/edit/' . $id);
        }

        if ($data['photo'] !== $oldPhoto) {
            Upload::remove($oldPhoto);
        }
        
        $this->logActivity('item.update', 'item', $id, $data['code'] . ' - ' . $data['name']);
        $this->flash('success', 'Barang berhasil diperbarui.');
        $this->redirect('items');
    }

    /** Soft delete: data tetap bisa dipulihkan. */
    public function delete($id = null): void
    {
        $this->authorize('items.delete');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('items');

        if (!$id) {
            $this->redirect('items');
        }

        $item = $this->item->find((int) $id);
        if ($item && $this->item->softDelete((int) $id)) {
            $this->logActivity('item.delete', 'item', (int) $id, $item['code'] . ' - ' . $item['name']);
            $this->flash('success', 'Barang dipindahkan ke sampah.');
        } else {
            $this->flash('danger', 'Barang gagal dihapus.');
        }

        $this->redirect('items');
    }

    public function trash(): void
    {
        $this->authorize('items.restore');

        $search     = query_param('search');
        $categoryId = query_param('category');
        $page       = max(1, (int) query_param('page', '1'));
        $limit      = $this->resolveLimit();

        $this->view('items/trash', [
            'title'        => 'Sampah Barang',
            'items'        => $this->item->paginate($limit, $page, $search, $categoryId, true),
            'categories'   => $this->category->all(),
            'search'       => $search,
            'category'     => $categoryId,
            'currentLimit' => $limit,
        ]);
    }

    public function restore($id = null): void
    {
        $this->authorize('items.restore');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('items/trash');

        if (!$id || !$this->item->find((int) $id, true)) {
            $this->flash('danger', 'Barang tidak ditemukan di sampah.');
            $this->redirect('items/trash');
        }

        if ($this->item->restore((int) $id)) {
            $this->logActivity('item.restore', 'item', (int) $id, 'Barang dipulihkan');
            $this->flash('success', 'Barang berhasil dipulihkan.');
        } else {
            $this->flash('danger', 'Barang gagal dipulihkan.');
        }

        $this->redirect('items/trash');
    }

    /** Detail barang + riwayat stok. */
    public function show($id = null): void
    {
        $this->authorize('items.view');

        $item = $id ? $this->item->find((int) $id) : null;
        if (!$item) {
            Security::abort(404, 'Barang tidak ditemukan', 'Barang yang Anda cari tidak ada atau sudah dihapus.');
        }

        $this->view('items/show', [
            'title'        => 'Detail Barang',
            'item'         => $item,
            'transactions' => $this->model('Transaction')->forItem((int) $item['id'], 20),
        ]);
    }

    private function payload(array $input): array
    {
        return [
            'code'        => $input['code'],
            'name'        => $input['name'],
            'category_id' => ($input['category_id'] ?? '') !== '' ? (int) $input['category_id'] : null,
            'quantity'    => (int) ($input['quantity'] ?? 0),
            'unit'        => ($input['unit'] ?? '') ?: 'unit',
            'price'       => (float) ($input['price'] ?? 0),
            'entry_date'  => ($input['entry_date'] ?? '') !== '' ? $input['entry_date'] : null,
            'description' => $input['description'] ?? '',
            'photo'       => null,
        ];
    }
}