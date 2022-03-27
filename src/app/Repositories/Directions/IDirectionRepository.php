<?php

namespace App\Repositories\Directions;

interface IDirectionRepository
{
    /**
     * @param integer $angle
     * @return string
     */
    public function findByAngle(int $angle): string;
}
