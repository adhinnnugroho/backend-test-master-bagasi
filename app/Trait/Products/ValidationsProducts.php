<?php

namespace App\Trait\Products;

trait ValidationsProducts
{
    public static function validationProduct($request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);
    }
}
