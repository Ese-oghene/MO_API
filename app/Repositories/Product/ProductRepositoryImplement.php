<?php

namespace App\Repositories\Product;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Product;

class ProductRepositoryImplement extends Eloquent implements ProductRepository{

    /**
    *
    * @property Model|mixed $model;
    */
    protected Product $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

     /**
     * Create a new product.
     */
    public function createProduct(array $data)
    {
        return $this->model->create($data);
    }


      /**
     * Update a product by ID.
     */
    public function updateProduct( $id,  $data)
    {
        $product = $this->model->findOrFail($id);
        $product->update($data);
        return $product;
    }

       /**
     * Find a product by ID.
     */
    public function findProductById(int $id)
    {
        return $this->model->with(['category', 'subCategory'])->findOrFail($id);
    }

     /**
     * Delete a product by ID.
     */
    public function deleteProduct(int $id)
    {
        return $this->model->destroy($id);
    }

    /**
     * Get all products with their category and subcategory.
     */
    public function getAllWithRelations()
    {
        return $this->model->with(['category', 'subCategory'])->get();
    }

    public function getProductsByCategory(int $categoryId)
    {
        return Product::with(['category', 'subCategory'])
            ->where('category_id', $categoryId)
            ->get();
    }

    public function getProductsBySubCategory(int $subCategoryId)
    {
        return Product::with(['category', 'subCategory'])
            ->where('sub_category_id', $subCategoryId)
            ->get();
    }


    public function getProductsByCategoryAndSubCategory(int $categoryId, int $subCategoryId)
    {
        return Product::with(['category', 'subCategory'])
            ->where('category_id', $categoryId)
            ->where('sub_category_id', $subCategoryId)
            ->get();
    }


    public function getProductsByCategoryName(string $name)
    {
        return Product::whereHas('category', function ($q) use ($name) {
                    $q->whereRaw('LOWER(name) = ?', [strtolower($name)]);
                })
                ->with(['category', 'subCategory'])
                ->get();
    }

    public function getProductsBySubCategoryName(string $name)
    {
        return Product::whereHas('subCategory', function ($q) use ($name) {
                    $q->whereRaw('LOWER(name) = ?', [strtolower($name)]);
                })
                ->with(['category', 'subCategory'])
                ->get();
    }

}
