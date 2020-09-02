<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;


/**
 * Define response key and the destination for request
 *
 * @author Yuta Aoki
 */
abstract class ExternalResponse
{
    /**
     * Request parameters
     */
    protected $request;
    protected $response;
    protected $data = [];
    protected $addedResponse;

    public function __construct(object $request)
    {
        $this->request = $request;
    }

    /**
     * Define where is requested
     */
    abstract public function apiRequest();

    /**
     * Format the response
     *
     * @return ?array
     */
    public function formatResponse() : ?array
    {
        $response = json_decode($this->response->getBody()->getContents(), true);
        $feature = $response[$this->addedResponse['response']];
        foreach($feature as $index => $value) {
            $this->addResponse($index, $value);
        }
        return $this->data;
    }

    /**
     * Add response parameters
     *
     * @param int $index
     * @param array $value
     */
    private function addResponse(int $index, array $value) : void
    {
        foreach($this->addedResponse['key'] as $array) {
            $variable = $this->get_value($value, $array['content']);
            $this->data['data'][$index][$array['name']] = $variable;
        }
    }

    /**
     * Get a value from response data finding by especially key
     *
     * @param array $value
     * @param string $path
     * @return ?string
     */
    private function get_value(array $value, string $path) : ?string
    {
        $path_array = array_filter(preg_split("/(\['|'\]|\[|\])/", $path), "strlen");
        foreach($path_array as $key) {
            if (!isset($value[$key])) {
                return NULL;
            }
            $value = $value[$key];
        }
        return $value;
    }
}
