<?php

namespace App\Trait\Products;

trait ScopeProducts
{
    public function scopeGetAllProduct($query)
    {
        return $query->all();
    }

    public function scopeDeleteProduct($query, $id)
    {
        return $query->findOrFail($id)->delete();
    }
}
