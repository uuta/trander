<?php

namespace App\Services\Strings;

use Location\Coordinate;
use Location\Formatter\Coordinate\DecimalDegrees;

class FormatLocationService
{
    private $lat;
    private $lng;

    public function __construct(float $lat, float $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function location() {
        return (new Coordinate($this->lat, $this->lng))->format(new DecimalDegrees(','));
    }
}
