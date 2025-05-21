<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Product\ProductService;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Http\Requests\Product\UpdateProductRequest;


/**
 * @group Product Management
 * @groupDescription Handles operations related to products, such as creation, listing, updating, and deletion.
 */

class ProductController extends Controller
{

    protected ProductService $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

     /**
     * List Products
     *
     * Returns a list of all products with their categories and subcategories.
     */

     public function index(): JsonResponse
     {
         return $this->productService->getAllProducts()->toJson();
     }

     /**
     * Create Product
     *
     * Creates a new product entry in the system.
     */
    public function store(ProductRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        return $this->productService->createProduct($data)->toJson();
    }

     /**
     * Show Product
     *
     * Returns details of a single product by its ID.
     */
    public function show(int $id): JsonResponse
    {
        return $this->productService->getProductById($id)->toJson();
    }

      /**
     * Update Product
     *
     * Updates a product’s details.
     */
        public function publicIndex(): JsonResponse
    {
        return $this->productService->getPublicProducts()->toJson();
    }

    /**
     * Update Product
     *
     * Updates a product’s details.
     */
    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {

        $data = $request->validated();

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
        $data['image'] = $imagePath;
    }

        return $this->productService->updateProduct($id, $data)->toJson();
    }

     /**
     * Delete Product
     *
     * Deletes a product by its ID.
     */
    public function destroy(int $id): JsonResponse
    {
        return $this->productService->deleteProduct($id)->toJson();
    }

    public function getByCategory($id)
    {
        return $this->productService->getProductsByCategory($id);
    }

    public function getBySubCategory($id)
    {
    return $this->productService->getProductsBySubCategory($id);
    }


    public function getByCategoryName($name)
    {
        return $this->productService->getProductsByCategoryName($name)->toJson();
    }

    
    public function getBySubCategoryName($name)
    {
        return $this->productService->getProductsBySubCategoryName($name)->toJson();
    }



}
