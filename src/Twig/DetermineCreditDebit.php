<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

// Twig service function, to determine if an amount is credit or debit.
class DetermineCreditDebit extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('isCr', [$this, 'isCr']),
            new TwigFunction('isDr', [$this, 'isDr']),
        ];
    }

    public function isCr($amount)
    {
        return $amount <= 0 ? true : false;
    }

    public function isDr($amount)
    {
        return $amount >= 0 ? true : false;
    }
}
