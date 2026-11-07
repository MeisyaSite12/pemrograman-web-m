<?php

class HomeController extends Controller
{
    public function __construct()
    {
        $this->requireLogin();
    }

    public function index(): void
    {
        $this->authorize('dashboard.view');

        $item = $this->model('Item');
        $trx  = $this->model('Transaction');

        $daily = $trx->dailyTotals(7);

        $this->view('dashboard/index', [
            'title'              => 'Dashboard',
            'totalItems'         => $item->totalItems(),
            'totalCategories'    => $this->model('Category')->count(),
            'totalStock'         => $item->totalStock(),
            'totalAssetValue'    => $item->totalAssetValue(),
            'lowStockCount'      => $item->lowStockCount(),
            'lowStockItems'      => $item->lowStockItems(),
            'todayTransactions'  => $trx->todayCount(),
            'recentTransactions' => $trx->recent(),
            'chartLabels'        => array_column($daily, 'label'),
            'chartIn'            => array_column($daily, 'in'),
            'chartOut'           => array_column($daily, 'out'),
            'topItems'           => $item->topStock(5),
        ]);
    }
}