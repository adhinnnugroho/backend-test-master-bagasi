<?php

namespace App\Trait\VoucherUsage;

trait CrudVoucherUsage
{
    public static function applyVoucer($userId, $voucherId)
    {
        return self::create([
            'user_id' => $userId,
            'voucher_id' => $voucherId,
            'used_at' => now()
        ]);
    }
}
