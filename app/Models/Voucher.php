<?php

namespace App\Models;

use App\Trait\Voucher\ScopeVoucher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    use ScopeVoucher;
    protected $guarded = ['id'];
}
