<?php
class HomeController extends Controller {
    public function __construct()
    {
    $this->requireLogin();
    }
    public function index(): void
    {
        $this->redirect('dashboard');
    }
}