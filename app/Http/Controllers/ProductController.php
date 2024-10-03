<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductInterface\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = $this->productRepository->all();
            return generateResponse('Product retrieved successfully.', $products);
        } catch (\Throwable $th) {
            return generateResponse($th->getMessage(), [], 500, 'error');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = Product::validationProduct($request);
            $product = $this->productRepository->create($data);
            return generateResponse('Product created successfully.', $product);
        } catch (\Throwable $th) {
            return generateResponse($th->getMessage(), [], 500, 'error');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $fetchProduct = $this->productRepository->find($id);
            if (!is_null($fetchProduct)) {
                return generateResponse('Product retrieved successfully.', $fetchProduct);
            }
            return generateResponse('Product not found.', [], 404, 'error');
        } catch (\Throwable $th) {
            return generateResponse($th->getMessage(), [], 500, 'error');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            if (!is_null($this->productRepository->find($id))) {
                $data  = Product::validationProduct($request);
                $this->productRepository->update($id, $data);
                return generateResponse('Product updated successfully.', $request->all());
            }
            return generateResponse('Product not found.', [], 404, 'error');
        } catch (\Throwable $th) {
            return generateResponse($th->getMessage(), [], 500,  'error');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->productRepository->delete($id);
            return generateResponse('Product deleted successfully.');
        } catch (\Throwable $th) {
            return generateResponse($th->getMessage(), [], 500, 'error');
        }
    }
}
