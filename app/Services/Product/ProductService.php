<?php

namespace App\Services\Product;

use LaravelEasyRepository\BaseService;

interface ProductService extends BaseService{

    public function createProduct(array $data);
    public function getAllProducts();
    public function getProductById(int $id);
    public function updateProduct(int $id, array $data);
    public function deleteProduct(int $id);
}
