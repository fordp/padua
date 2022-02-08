<?php

namespace App\Utils;

class TransactionCode
{
    // All valid characters for a Transaction Code.
    private $validChars = array(
        '2', '3', '4', '5', '6', '7', '8', '9',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M',
        'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
    );

    /**
     * From the supplied string, generate the Check Character that can then be
     * used to validate a Transaction Code/Number.
     */
    function generateCheckCharacter(string $input)
    {
        (int)$factor = 2;
        (int)$sum = 0;
        (int)$n = count($this->validChars);

        // Starting from the right and working leftwards is easier since
        // the initial "factor" will always be "2"
        for ($i = strlen($input) - 1; $i >= 0; $i--) {
            (int)$codePoint = array_search($input[$i], $this->validChars);
            (int)$addend = $factor * $codePoint;

            // Alternate the "factor" that each "codePoint" is multiplied by
            $factor = ($factor == 2) ? 1 : 2;

            // Sum the digits of the "addend" as expressed in base "n"
            $addend = ($addend / $n) + ($addend % $n);
            $sum += $addend;
        }

        // Calculate the number that must be added to the "sum"
        // to make it divisible by "n"
        (int)$remainder = $sum % $n;
        (int)$checkCodePoint = ($n - $remainder) % $n;

        return $this->validChars[$checkCodePoint];
    }
}
