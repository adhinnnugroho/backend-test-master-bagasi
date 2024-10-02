<?php

namespace App\Trait\Voucher;

trait ScopeVoucher
{
    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }
}
