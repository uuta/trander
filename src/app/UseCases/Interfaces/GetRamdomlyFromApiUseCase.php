<?php

namespace App\UseCases\Interfaces;

interface GetRamdomlyFromApiUseCase
{
    /**
     * @return ?array
     */
    public function handle(int $user_id, int $type_id);
}
