<?php

class TransactionsController extends Controller {

    public function __construct() {
        $this->requireLogin();
    }

    public function index(): void {
        $limit = (int) ($_GET['limit'] ?? 10);
        if (!in_array($limit, [5, 10, 20, 50, 100], true)) $limit = 10;
        $page = max(1, (int) ($_GET['page'] ?? 1));

        $this->authorize('transactions.view');

        $this->view('transactions/index', [
            'title' => 'Riwayat Transaksi',
            'transactions' => $this->model('Transaction')->paginate($limit, $page, 'i.unit as unit'),
            'currentLimit' => $limit,
        ]);
    }

    public function stockIn(): void  { 
        $this->authorize('transactions.create');
        $this->record('IN',  'Barang masuk berhasil dicatat!'); }

    public function stockOut(): void {
        $this->authorize('transactions.create');
        $this->record('OUT', 'Barang keluar berhasil dicatat!'); }

    private function record(string $type, string $msg): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('transactions');

        $itemId = (int) ($_POST['item_id'] ?? 0);
        $qty    = (int) ($_POST['quantity'] ?? 0);
        if ($itemId <= 0 || $qty <= 0) {
            $this->flash('danger', 'Data tidak valid.');
            $this->redirect('items');
        }

        $ok = $this->model('Transaction')->create([
            'item_id'  => $itemId,
            'user_id'  => $_SESSION['user']['id'],
            'type'     => $type,
            'quantity' => $qty,
            'notes'    => trim($_POST['notes'] ?? '') ?: null,
        ]);

        if ($ok) {
            $this->logActivity('stock.' . strtolower($type), 'item', $itemId, $type . ' ' . $qty . ' unit');
        }

        $this->flash($ok ? 'success' : 'danger', $ok ? $msg : 'Gagal. Stok tidak mencukupi atau barang tidak ditemukan.');
        $this->redirect('items');
    }
}