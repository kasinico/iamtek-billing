<?php

namespace App\Services;

class VoucherService
{
    public function generateCode()
    {
        return 'IAM-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
    }

    public function generateUsername()
    {
        return strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
    }

    public function generatePassword()
    {
        return strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
    }
}