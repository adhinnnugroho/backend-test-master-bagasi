<?php

namespace App\Models;

use App\Trait\VoucherUsage\{ScopeVoucherUsage, CrudVoucherUsage};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherUsage extends Model
{
    use ScopeVoucherUsage, CrudVoucherUsage;
    use HasFactory;
    protected $guarded = ['id'];
}
