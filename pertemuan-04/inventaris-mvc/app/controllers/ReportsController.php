<?php

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->requireLogin();
    }

    public function index(): void
    {
        $this->lowStock();
    }

    public function lowStock(): void
    {
        $from = $this->validDate(trim($_GET['from'] ?? ''));
        $to = $this->validDate(trim($_GET['to'] ?? ''));

        $this->view('reports/low_stock', [
            'title' => 'Laporan Stok Menipis',
            'rows' => $this->model('Item')->lowStockReport($from, $to),
            'from' => $from,
            'to' => $to,
        ]);
    }

    private function validDate(string $d): string
    {
        $dt = DateTime::createFromFormat('Y-m-d', $d);
        return ($dt && $dt->format('Y-m-d') === $d) ? $d : '';
    }
}