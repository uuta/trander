<?php

namespace App\Services\Distance;

// Guzzleモジュールのクラス読み込み
use Illuminate\Support\Facades\Log;
use Location\Coordinate;
use Location\Distance\Vincenty;
use Location\Bearing\BearingSpherical;
use Illuminate\Support\Facades\DB;
use App\Http\Models\MWay;

class Get
{
    private $direction;
    private $distance;
    private $angle;

    public function __construct(object $request)
    {
        $this->request = $request;
    }

    /**
     * Get the angle among the 2 location
     */
    public function getAngle(): void
    {
        $current = new Coordinate($this->request->lat, $this->request->lng);
        $city = new Coordinate($this->request->target_lat, $this->request->target_lng);

        $bearingCalculator = new BearingSpherical();
        $this->angle = $bearingCalculator->calculateBearing($current, $city);
    }

    /**
     * Get and add values into response
     *
     * @return array
     */
    public function getResponse(): array
    {
        // Add the distance among 2 location
        $data['distance'] = $this->get_distance();

        // Add the ways of recommendation
        $data['ways'] = $this->get_way_of_recommend();

        // Add the direction
        $data['direction'] = $this->get_direction();

        return $data;
    }

    /**
     * Get the distance among 2 location
     *
     * @return float
     */
    private function get_distance(): float
    {
        $coordinate1 = new Coordinate($this->request->lat, $this->request->lng);
        $coordinate2 = new Coordinate($this->request->target_lat, $this->request->target_lng);
        $calculator = new Vincenty();
        $distance = ($calculator->getDistance($coordinate1, $coordinate2) * 0.001);
        $this->distance = (float)round($distance, 1);
        return $this->distance;
    }

    /**
     * Get the recommend frequencies of ways
     *
     * @return array
     */
    private function get_way_of_recommend(): array
    {
        $ways = [];
        foreach (MWay::WAYS as $key => $value) {
            $way = DB::table('m_ways')->where([
                ['way_id', $value],
                ['min_distance', '<=', $this->distance],
                ['max_distance', '>', $this->distance]
            ])->get();
            $ways[$key] = $way[0]->recommend_frequency;
        }
        return $ways;
    }

    /**
     * Get a direction from the angle
     * @return string
     */
    private function get_direction(): string
    {
        $data = DB::table('m_directions')->where([
            ['min_angle', '<=', $this->angle],
            ['max_angle', '>', $this->angle]
        ])->get();
        $this->direction = $data[0]->direction_name;
        return $this->direction;
    }
}
