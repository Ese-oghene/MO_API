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

}
