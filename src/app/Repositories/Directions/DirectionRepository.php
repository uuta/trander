<?php

namespace App\Repositories\Directions;

use Illuminate\Support\Facades\DB;
use App\Repositories\Directions\IDirectionRepository;

class DirectionRepository implements IDirectionRepository
{
    protected $table = 'm_directions';

    public function findByAngle(int $angle): string
    {
        $data = DB::table($this->table)->where([
            ['min_angle', '<=', $angle],
            ['max_angle', '>', $angle]
        ])->get();
        return $data[0]->direction_name;
    }
}
