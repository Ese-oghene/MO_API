<?php

namespace App\Repositories\Product;

use LaravelEasyRepository\Repository;

interface ProductRepository extends Repository{

    public function createProduct(array $data);

    public function updateProduct(int $id, array $data);

    public function findProductById(int $id);

    public function deleteProduct(int $id);

    public function getAllWithRelations();

    public function getProductsByCategory(int $categoryId);

    public function getProductsBySubCategory(int $subCategoryId);

       // Added methods
    public function getProductsByCategoryName(string $name);

    public function getProductsBySubCategoryName(string $name);
}
