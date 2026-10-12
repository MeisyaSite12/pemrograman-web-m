<?php


class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->requireRole('admin');
    }
    public function index(): void
    {
        $this->view('categories/index', [
            'title' => 'Data Kategori',
            'categories' => $this->model('Category')->all(),
        ]);
    }

    public function create(): void
    {
        $this->view('categories/create', ['title' => 'Tambah Kategori']);
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('categories');
        }

        $input = array_map('trim', $_POST);
        if (empty($input['name'])) {
            $this->flash('danger', 'Nama kategori wajib diisi.');
            $this->redirect('categories/create');
        }

        $this->model('Category')->create([
            'name' => $input['name'],
            'description' => $input['description'] ?? '',
        ]);
        $this->flash('success', 'Kategori berhasil ditambahkan.');
        $this->redirect('categories');
    }

    public function edit($id = 0): void
    {
        $category = $this->model('Category')->find((int) $id);
        if (!$category) {
            $this->flash('danger', 'Kategori tidak ditemukan.');
            $this->redirect('categories');
        }

        $this->view('categories/edit', [
            'title' => 'Ubah Kategori',
            'category' => $category,
        ]);
    }

    public function update($id = 0): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('categories');
        }

        $input = array_map('trim', $_POST);
        if (empty($input['name'])) {
            $this->flash('danger', 'Nama kategori wajib diisi.');
            $this->redirect('categories/edit/' . (int) $id);
        }

        $this->model('Category')->update((int) $id, [
            'name' => $input['name'],
            'description' => $input['description'] ?? '',
        ]);
        $this->flash('success', 'Kategori berhasil diubah.');
        $this->redirect('categories');
    }

    public function delete($id = 0): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('categories');
        }

        $this->model('Category')->delete((int) $id);
        $this->flash('success', 'Kategori berhasil dihapus.');
        $this->redirect('categories');
    }
}