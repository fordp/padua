<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use App\Utils\TransactionCode;

class VerifyTransCode extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('verifyCode', [$this, 'verifyCode']),
        ];
    }

    public function verifyCode($key)
    {
        if (strlen($key) != 10) {
            return false;
        }

        $tc = new TransactionCode;

        (string)$checkDigit = $tc->generateCheckCharacter(substr(strtoupper($key), 0, 9));

        return $key[9] == $checkDigit ? 'Yes' : 'No';
    }
}
