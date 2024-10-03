<?php

namespace App\Models;

use App\Trait\Products\{ScopeProducts, CrudProducts, ValidationsProducts};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use ScopeProducts, CrudProducts, ValidationsProducts;


    protected $guarded = ['id'];
}
