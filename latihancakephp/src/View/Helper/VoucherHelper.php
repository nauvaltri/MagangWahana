<?php

namespace App\View\Helper;

use Cake\View\Helper;

class VoucherHelper extends Helper
{
    public function getVoucher($totalPrice)
    {
        if ($totalPrice > 30000000) {
            return 'Voucher Hotel Santika';
        } else {
            return 'Voucher Belanja Indomaret';
        }
    }
}