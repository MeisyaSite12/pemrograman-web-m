<?php

class ItemsController extends Controller
{
    public function __construct()
    {
        $this->requireLogin();
    }

    public function index(): void
    {
        $limit = (int) ($_GET['limit'] ?? 10);
        if (!in_array($limit, [5, 10, 20, 50, 100], true)) {
            $limit = 10;
        }
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $search = trim($_GET['search'] ?? '');
        $category = trim($_GET['category'] ?? '');

        $result = $this->model('Item')->paginate($limit, $page, $search, $category);

        $this->view('items/index', [
            'title' => 'Data Barang',
            'items' => $result['data'],
            'result' => $result,
            'categories' => $this->model('Category')->all(),
            'search' => $search,
            'category' => $category,
            'limit' => $limit,
        ]);
    }

    // Fitur 4: detail barang + riwayat transaksi
    public function show($id = 0): void
    {
        $item = $this->model('Item')->findDetail((int) $id);
        if (!$item) {
            $this->flash('danger', 'Barang tidak ditemukan.');
            $this->redirect('items');
        }

        $this->view('items/show', [
            'title' => 'Detail Barang',
            'item' => $item,
            'transactions' => $this->model('Transaction')->byItem((int) $id),
        ]);
    }

    // Fitur 1: export CSV
    public function export(): void
    {
        $items = $this->model('Item')->all();

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="barang-' . date('Ymd') . '.csv"');

        $out = fopen('php://output', 'w');
        fwrite($out, "\xEF\xBB\xBF"); // BOM agar Excel membaca UTF-8
        fputcsv($out, ['Kode', 'Nama', 'Kategori', 'Stok', 'Satuan', 'Harga', 'Tanggal Masuk'], ',', '"', '');
        foreach ($items as $r) {
            fputcsv($out, [
                $r['code'], $r['name'], $r['category_name'] ?? '', $r['quantity'],
                $r['unit'], $r['price'], $r['entry_date'],
            ], ',', '"', '');
        }
        fclose($out);
        exit;
    }

    public function create(): void
    {
        $this->requireRole('admin');
        $this->view('items/create', [
            'title' => 'Tambah Barang',
            'categories' => $this->model('Category')->all(),
            'code' => $this->model('Item')->generateCode(),
        ]);
    }

    public function store(): void
    {
        $this->requireRole('admin');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('items');
        }

        $input = array_map('trim', $_POST);
        if (empty($input['name'])) {
            $this->flash('danger', 'Nama barang wajib diisi.');
            $this->redirect('items/create');
        }

        $this->model('Item')->create($this->payload($input));
        $this->flash('success', 'Barang berhasil ditambahkan.');
        $this->redirect('items');
    }

    public function edit($id = 0): void
    {
        $this->requireRole('admin');
        $item = $this->model('Item')->find((int) $id);
        if (!$item) {
            $this->flash('danger', 'Barang tidak ditemukan.');
            $this->redirect('items');
        }

        $this->view('items/edit', [
            'title' => 'Ubah Barang',
            'item' => $item,
            'code' => $item['code'],
            'categories' => $this->model('Category')->all(),
        ]);
    }

    public function update($id = 0): void
    {
        $this->requireRole('admin');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('items');
        }

        $input = array_map('trim', $_POST);
        if (empty($input['name'])) {
            $this->flash('danger', 'Nama barang wajib diisi.');
            $this->redirect('items/edit/' . (int) $id);
        }

        $this->model('Item')->update((int) $id, $this->payload($input));
        $this->flash('success', 'Barang berhasil diubah.');
        $this->redirect('items');
    }

    public function delete($id = 0): void
    {
        $this->requireRole('admin');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('items');
        }

        $this->model('Item')->delete((int) $id);
        $this->flash('success', 'Barang berhasil dihapus.');
        $this->redirect('items');
    }

    private function payload(array $input): array
    {
        return [
            'code' => $input['code'],
            'name' => $input['name'],
            'category_id' => ($input['category_id'] ?? '') !== '' ? (int)$input['category_id'] : null,
            'quantity' => (int)($input['quantity'] ?? 0),
            'unit' => $input['unit'] ?: 'unit',
            'price' => (float)($input['price'] ?? 0),
            'entry_date' => ($input['entry_date'] ?? '') !== '' ? $input['entry_date'] : null,
            'description' => $input['description'] ?? '',
        ];
    }
}