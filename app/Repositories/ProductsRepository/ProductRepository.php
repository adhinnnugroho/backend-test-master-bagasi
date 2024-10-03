<?php

use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function all()
    {
        return Product::all();
    }

    public function find($id)
    {
        return Product::find($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update($id, array $data)
    {
        $product = Product::find($id);
        if ($product) {
            return $product->update($data);
        }
        return null;
    }

    public function delete($id)
    {
        $product = Product::find($id);
        if ($product) {
            return $product->delete();
        }
        return null;
    }
}
