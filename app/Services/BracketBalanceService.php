<?php

namespace app\Services;

use Exception;

class BracketBalanceService
{
    public function isBalanced($string)
    {
        $stack = [];
        $brackets = [
            '(' => ')',
            '{' => '}',
            '[' => ']',
        ];

        foreach (str_split($string) as $char) {
            if (isset($brackets[$char])) {
                $stack[] = $char;
            } elseif (in_array($char, $brackets)) {
                if (empty($stack) || $brackets[array_pop($stack)] !== $char) {
                    return false;
                }
            }
        }

        return empty($stack);
    }
}
