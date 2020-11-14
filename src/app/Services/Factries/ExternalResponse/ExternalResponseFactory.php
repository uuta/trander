<?php

namespace App\Services\Factries\ExternalResponse;

use Illuminate\Support\Facades\Log;
use App\Services\Factries\ExternalResponse\First;
use App\Services\Factries\ExternalResponse\Second;

/**
 * Define response key and the destination for request
 *
 * @author Yuta Aoki
 */
abstract class ExternalResponseFactory
{
    const HIERARCHY = [
        'first' => 0,
        'second' => 1,
    ];

    protected $response;

    public function __construct(object $request)
    {
        $this->request = $request;
    }

    /**
     * Define where is requested
     */
    abstract public function apiRequest();

    /**
     * Make sure the architecture of hierarchy in response and assign a class
     */
    public function get_response() {
        if (array_key_exists('hierarchy', $this->addedResponse))
        {
            if($this->addedResponse['hierarchy'] === $this::HIERARCHY['first']) {
                return new First($this->request, $this->response, $this->addedResponse);
            };
            if($this->addedResponse['hierarchy'] === $this::HIERARCHY['second']) {
                return new Second($this->request, $this->response, $this->addedResponse);
            };
        }
    }
}
