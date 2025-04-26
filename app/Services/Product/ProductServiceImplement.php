<?php

namespace App\Services\Product;
use App\Http\Resources\ProductResource;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\Product\ProductRepository;

class ProductServiceImplement extends ServiceApi implements ProductService{

    /**
     * set title message api for CRUD
     * @param string $title
     */
     protected string $title = "";
     /**
     * uncomment this to override the default message
     * protected string $create_message = "";
     * protected string $update_message = "";
     * protected string $delete_message = "";
     */

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
      $this->productRepository = $productRepository;
    }

    public function createProduct(array $data): ProductService
    {
        try {
            $product = $this->productRepository->create($data);

            return $this->setCode(201)
                ->setMessage("Product Created Successfully")
                ->setData(new ProductResource($product));
        } catch (\Exception $e) {
            return $this->setCode(400)
                ->setMessage("Product Creation Failed")
                ->setError($e->getMessage());
        }
    }

    public function getAllProducts(): ProductService
    {
        try {
            $products = $this->productRepository->getAllWithRelations();

            return $this->setCode(200)
                ->setMessage("Product List")
                ->setData(ProductResource::collection($products));
        } catch (\Exception $e) {
            return $this->setCode(400)
                ->setMessage("Failed to fetch products")
                ->setError($e->getMessage());
        }
    }


    public function getProductById(int $id): ProductService
    {
        try {
            $product = $this->productRepository->findProductById($id);

            if (!$product) {
                return $this->setCode(404)->setMessage("Product Not Found");
            }

            return $this->setCode(200)
                ->setMessage("Product Details")
                ->setData(new ProductResource($product));
        } catch (\Exception $e) {
            return $this->setCode(400)
                ->setMessage("Failed to fetch product")
                ->setError($e->getMessage());
        }
    }

    public function updateProduct(int $id, array $data): ProductService
    {
        try {
            $product = $this->productRepository->update($id, $data);

            return $this->setCode(200)
                ->setMessage("Product Updated Successfully")
                ->setData(new ProductResource($product));
        } catch (\Exception $e) {
            return $this->setCode(400)
                ->setMessage("Product Update Failed")
                ->setError($e->getMessage());
        }
    }

    public function deleteProduct(int $id): ProductService
    {
        try {
            $deleted = $this->productRepository->delete($id);

            if (!$deleted) {
                return $this->setCode(404)->setMessage("Product Not Found or Already Deleted");
            }

            return $this->setCode(200)
                ->setMessage("Product Deleted Successfully");
        } catch (\Exception $e) {
            return $this->setCode(400)
                ->setMessage("Product Deletion Failed")
                ->setError($e->getMessage());
        }
    }

    // Define your custom methods :)
}
