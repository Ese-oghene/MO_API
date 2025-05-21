<?php

namespace App\Services\Product;

use App\Models\Category;
use App\Models\SubCategory;
use LaravelEasyRepository\ServiceApi;
use App\Http\Resources\ProductResource;
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

             // Create or get Category by name
            $category = Category::firstOrCreate(
                ['name' => $data['category_name']]
            );

            // Create or get SubCategory by name + link it to the category
            $subCategory = SubCategory::firstOrCreate(
                [
                    'name' => $data['sub_category_name'],
                    'category_id' => $category->id,
                ]
            );

            // Replace names with actual foreign keys
            $data['category_id'] = $category->id;
            $data['sub_category_id'] = $subCategory->id;

            unset($data['category_name'], $data['sub_category_name']);

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

            // Handle optional category name
            if (!empty($data['category_name'])) {
                $category = Category::firstOrCreate(['name' => $data['category_name']]);
                $data['category_id'] = $category->id;
                unset($data['category_name']);
            }

            if (!empty($data['sub_category_name'])) {
                $categoryId = $data['category_id'] ?? null;

                // Ensure a valid category_id exists before creating a sub-category
                if ($categoryId) {
                    $subCategory = SubCategory::firstOrCreate([
                        'name' => $data['sub_category_name'],
                        'category_id' => $categoryId,
                    ]);
                    $data['sub_category_id'] = $subCategory->id;
                    unset($data['sub_category_name']);
                }
            }

            $product = $this->productRepository->updateProduct($id, $data);

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

    public function getPublicProducts(): ProductService
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


    public function getProductsByCategoryName(string $name): ProductService
    {
        try {
            $products = $this->productRepository->getProductsByCategoryName($name);

            return $this->setCode(200)
                ->setMessage("Products by Category Name")
                ->setData(ProductResource::collection($products));

        } catch (\Exception $e) {

            return $this->setCode(400)
                ->setMessage("Failed to fetch products by category name")
                ->setError($e->getMessage());
        }
    }


    public function getProductsBySubCategoryName(string $name): ProductService
    {
        try {
            $products = $this->productRepository->getProductsBySubCategoryName($name);

            return $this->setCode(200)
                ->setMessage("Products by SubCategory Name")
                ->setData(ProductResource::collection($products));

        } catch (\Exception $e) {
            return $this->setCode(400)
                ->setMessage("Failed to fetch products by subcategory name")
                ->setError($e->getMessage());
        }
    }

    public function getProductsByCategory(int $categoryId): ProductService
        {
            try {
                $products = $this->productRepository->getProductsByCategory($categoryId);

                return $this->setCode(200)
                    ->setMessage("Products by Category")
                    ->setData(ProductResource::collection($products));
            } catch (\Exception $e) {
                return $this->setCode(400)
                    ->setMessage("Failed to fetch products by category")
                    ->setError($e->getMessage());
            }
        }

    public function getProductsBySubCategory(int $subCategoryId): ProductService
    {
        try {
            $products = $this->productRepository->getProductsBySubCategory($subCategoryId);

            return $this->setCode(200)
                ->setMessage("Products by SubCategory")
                ->setData(ProductResource::collection($products));
        } catch (\Exception $e) {
            return $this->setCode(400)
                ->setMessage("Failed to fetch products by subcategory")
                ->setError($e->getMessage());
        }
    }





}

// 122|jcoZCJv16lnJVtBKfT6KaAYUzLm5K4B438lDi5EEedc8d052
