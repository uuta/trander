<?php

namespace App\UseCases\Interfaces;

interface GetRamdomlyFromApiUseCase
{
    /**
     * @return ?array
     */
    public function handle(int $user_id, int $type_id);

    /**
     * @return void
     */
    public function _apiRequest();

    /**
     * @return void
     */
    public function _verifyEmpty();

    /**
     * @return void
     */
    public function _getContentRandomly();

    /**
     * @return void
     */
    public function _formatResponse();

    /**
     * @return array
     */
    public function _return();
}
