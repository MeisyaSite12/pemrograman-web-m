<?php

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->requireLogin();
    }

    public function index(): void
    {
        $item = $this->model('Item');
        $trx = $this->model('Transaction');

        $this->view('dashboard/index', [
            'title' => 'Dashboard',
            'totalItems' => $item->totalItems(),
            'totalStock' => $item->totalStock(),
            'assetValue' => $item->totalAssetValue(),
            'lowStockCount' => $item->lowStockCount(),
            'lowStockItems' => $item->lowStockItems(),
            'recentTransactions' => $trx->recent(5),
            'todayCount' => $trx->todayCount(),
        ]);
    }
}