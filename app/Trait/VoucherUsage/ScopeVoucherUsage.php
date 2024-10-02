<?php

namespace App\Trait\VoucherUsage;

trait ScopeVoucherUsage
{
    public function scopeVoucherAlreadyUsedByUser($query, $userId, $voucherId)
    {
        return $query->where('user_id', $userId)
            ->where('voucher_id', $voucherId);
    }
}
