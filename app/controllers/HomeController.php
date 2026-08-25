<?php
// app/controllers/HomeController.php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Product.php';

class HomeController extends BaseController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function index(): void
    {
        $products = $this->productModel->getAllActive();
        $this->render('public/home', [
            'products' => $products
        ]);
    }
}
