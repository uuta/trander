<?php

namespace App\Services\Facades;

use Location\Bearing\BearingEllipsoidal;
use Location\Coordinate;
use Location\Formatter\Coordinate\DecimalDegrees;
use Location\Distance\Vincenty;
use App\Http\Models\Setting;

class GenerateLocationService
{
    public $distance;
    public $angle;
    public $location;
    public $formatted_location;
    public $min;
    public $max;
    public $direction_type;
    public $lat;
    public $lng;

    /**
     * Initial method
     *
     * @param [type] $request
     * @return void
     */
    public function handle($request): void
    {
        $this->min = $request->min * 1000;
        $this->max = $request->max * 1000;
        $this->direction_type = $request->direction_type;
        $this->lat = $request->lat;
        $this->lng = $request->lng;

        $this->_generateAngle();
        $this->_generateDistance();
        $this->_generateSuggestingLocation();
        $this->_generateFormattedLocation();
    }

    /**
     * Generate a distance randomly
     *
     * @return void
     */
    private function _generateSuggestingLocation(): void
    {
        $currentLocation = new Coordinate($this->lat, $this->lng);
        $bearingEllipsoidal = new BearingEllipsoidal();
        $destination = $bearingEllipsoidal->calculateDestination($currentLocation, $this->angle, $this->distance);
        $this->location = $destination->format(new DecimalDegrees(','));
    }

    /**
     * Generate an angle randomly
     *
     * @return void
     */
    private function _generateAngle(): void
    {
        // Only when direction_type is north, get 0 or 1
        $num = mt_rand(0, 1);
        $direction = (int) $this->direction_type === Setting::DIRECTION_TYPE['north']
            ? Setting::DIRECTION_ANGLE[1][$num]
            : Setting::DIRECTION_ANGLE[$this->direction_type];

        if (
            $direction === Setting::DIRECTION_ANGLE[1][1]
            || (int) $this->direction_type === Setting::DIRECTION_TYPE['south']
            || (int) $this->direction_type === Setting::DIRECTION_TYPE['west']
        ) {
            $angle = $direction['min'] + mt_rand() / mt_getrandmax() * ($direction['max'] - $direction['min']);
        } else {
            $angle = mt_rand() / mt_getrandmax() * $direction['max'];
        }
        $this->angle = $angle;
    }

    /**
     * Generate a distance randomly
     *
     * @return void
     */
    private function _generateDistance(): void
    {
        $this->distance = rand($this->min, $this->max);
    }

    /**
     * Get a formatted location randomly based on the current location
     *
     * @return void
     */
    private function _generateFormattedLocation(): void
    {
        $formatted = '';
        $arr = explode(',', $this->location);
        foreach ($arr as $value) {
            if (strpos($value, '-') !== true) {
                $value = '+' . $value;
            }
            $formatted .= $value;
        }
        $this->formatted_location = $formatted;
    }

    /**
     * Calculate the distance between current and suggested location
     *
     * @param float $latitude
     * @param float $longitude
     * @return float
     */
    public function getDistance(float $latitude, float $longitude): float
    {
        $coordinate1 = new Coordinate($this->lat, $this->lng);
        $coordinate2 = new Coordinate($latitude, $longitude);
        $calculator = new Vincenty();
        $distance = ($calculator->getDistance($coordinate1, $coordinate2) * 0.001);
        return (float)round($distance, 1);
    }
}
