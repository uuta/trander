<?php

namespace App\Services\Factries\ExternalResponse;

use App\Http\Models\MRating;
use Illuminate\Support\Facades\DB;

/**
 * Base class for external response
 *
 * @author Yuta Aoki
 */
class Base
{
    const PROCESSING = [
        'RATING' => 0
    ];

    /**
     * Request parameters
     */
    protected $request;
    protected $response;
    protected $data = [];
    protected $addedResponse;

    public function __construct(object $request, object $response, array $addedResponse)
    {
        $this->request = $request;
        $this->response = $response;
        $this->addedResponse = $addedResponse;
    }

    /**
     * Add a star rating to response by using reviewed score
     *
     * @param float $variable
     * @return ?string
     */
    protected function get_rating(float $variable): ?string
    {
        $MRating = new MRating();
        $rating = $MRating->get_rating($variable);
        return isset($rating->class_name) ? $rating->class_name : NULL;
    }
}
