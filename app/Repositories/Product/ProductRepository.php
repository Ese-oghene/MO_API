<?php

namespace App\Repositories\Product;

use LaravelEasyRepository\Repository;

interface ProductRepository extends Repository{

    public function createProduct(array $data);
    public function updateProduct(int $id, array $data);
    public function findProductById(int $id);
    public function deleteProduct(int $id);
    public function getAllWithRelations(); // To include category and subcategory
}
