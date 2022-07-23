<?php

namespace App\Services\Strings;

/**
 * Generate a random string.
 */
class GenerateStringRandomlyService
{
    const ALPHABET = 'abcdefghijklmnopqrstuvwxyz';
    const DEFAULT_LENGTH = 1;
    private $text;

    public function __construct(string $t = '')
    {
        $this->text = self::ALPHABET;
        if (isset($t) && !is_array($t) && $t !== '') {
            $this->text = $t;
        }
    }

    public function get(int $l = self::DEFAULT_LENGTH): string
    {
        return array_reduce(range(1, $l), function($p){ return $p.str_shuffle($this->text)[0]; });
    }
}
