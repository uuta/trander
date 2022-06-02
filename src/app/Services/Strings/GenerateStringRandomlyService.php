<?php

namespace App\Services\Strings;

class GenerateStringRandomlyService
{
    const ALPHABET = 'abcdefghijklmnopqrstuvwxyz';
    const DEFAULT_LENGTH = 1;
    private $text;

    public function __construct(string $t = '')
    {
        if (isset($t) || !is_array($t) || $t !== '') {
            $this->text = $t;
        }
        $this->text = self::ALPHABET;
    }

    public function get(int $l = self::DEFAULT_LENGTH): string
    {
        return substr(str_shuffle($this->text), 0, $l);
    }
}
