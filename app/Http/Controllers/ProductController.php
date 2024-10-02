<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Product::all();
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
            $validationRequest = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'quantity' => 'required|integer',
            ]);

            $createProduct = Product::create($validationRequest);
            return generateResponse('Product created successfully.', $createProduct);
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
            $fetchProduct = Product::find($id);
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
            $fetchProduct = Product::find($id);
            if (!is_null($fetchProduct)) {
                $validationRequest = $request->validate([
                    'name' => 'required|string|max:255',
                    'price' => 'required|numeric',
                    'quantity' => 'required|integer',
                ]);

                $fetchProduct->update($validationRequest);
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
            $fetchProduct = Product::findOrFail($id);
            $fetchProduct->delete();
            return generateResponse('Product deleted successfully.');
        } catch (\Throwable $th) {
            return generateResponse($th->getMessage(), [], 500, 'error');
        }
    }
}
