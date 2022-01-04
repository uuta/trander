<?php

namespace App\Services\Facades;

use Location\Bearing\BearingEllipsoidal;
use Location\Coordinate;
use Location\Formatter\Coordinate\DecimalDegrees;
use App\Setting;

class GenerateLocation
{
    private $distance;
    private $angle;
    private $location;

    public function __construct(object $request)
    {
        $this->request = $request;
        $this->request->min = $request->min * 1000;
        $this->request->max = $request->max * 1000;

        $this->generate_angle();
        $this->generate_distance();
        $this->generate_suggesting_location();
    }

    /**
     * Get a location randomly based on the current location
     *
     * @return string
     */
    public function generate_location(): string
    {
        return $this->location;
    }

    /**
     * Get a formatted location randomly based on the current location
     *
     * @return string
     */
    public function generate_formatted_location(): string
    {
        return $this->format();
    }

    /**
     * Get the angle
     *
     * @return float
     */
    public function get_angle(): float
    {
        return $this->angle;
    }

    /**
     * Generate an angle randomly
     */
    private function generate_angle()
    {
        // Only when direction_type is north, get 0 or 1
        $num = mt_rand(0, 1);
        $direction = (int) $this->request->direction_type === Setting::DIRECTION_TYPE['north']
            ? Setting::DIRECTION_ANGLE[1][$num]
            : Setting::DIRECTION_ANGLE[$this->request->direction_type];

        if (
            $direction === Setting::DIRECTION_ANGLE[1][1]
            || (int) $this->request->direction_type === Setting::DIRECTION_TYPE['south']
            || (int) $this->request->direction_type === Setting::DIRECTION_TYPE['west']
        ) {
            $angle = $direction['min'] + mt_rand() / mt_getrandmax() * ($direction['max'] - $direction['min']);
        } else {
            $angle = mt_rand() / mt_getrandmax() * $direction['max'];
        }
        $this->angle = $angle;
    }

    /**
     * Generate a distance randomly
     */
    private function generate_distance()
    {
        $min = $this->request->min;
        $max = $this->request->max;
        $this->distance = rand($min, $max);
    }

    /**
     * Generate a distance randomly
     */
    private function generate_suggesting_location()
    {
        $currentLocation = new Coordinate($this->request->lat, $this->request->lng);
        $bearingEllipsoidal = new BearingEllipsoidal();
        $destination = $bearingEllipsoidal->calculateDestination($currentLocation, $this->angle, $this->distance);
        $this->location = $destination->format(new DecimalDegrees(','));
    }

    /**
     * Decent form of latitude and longitude
     *
     * @return string
     */
    private function format(): string
    {
        $formatted = '';
        $arr = explode(',', $this->location);
        foreach ($arr as $value) {
            if (strpos($value, '-') !== true) {
                $value = '+' . $value;
            }
            $formatted .= $value;
        }
        return $formatted;
    }
}
