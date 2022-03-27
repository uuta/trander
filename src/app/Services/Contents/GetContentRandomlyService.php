<?php

namespace App\Services\Contents;

class GetContentRandomlyService
{
    public $content;

    public function handle(array $contents): void
    {
        $index = array_rand($contents);
        $this->content = $contents[$index];
    }
}
