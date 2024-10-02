<?php

namespace App\Trait\Voucher;

trait VoucherValidationsTrait
{
    public function validationApplyVoucher($fetchVoucher)
    {
        if (is_null($fetchVoucher)) {
            return generateResponse('Voucher not found.', [], 404, 'error');
        }

        // Check if voucher is expired
        if ($fetchVoucher->expiry_date < now()) {
            return generateResponse('Voucher expired.', [], 400, 'error');
        }

        // Check if voucher is not activated yet
        if ($fetchVoucher->activation_date > now() && $fetchVoucher->status == 'deactive') {
            return generateResponse('Voucher not yet activated.', [], 400, 'error');
        }
    }
}
