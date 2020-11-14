<?php

namespace App\Services\Factries\ExternalResponse;

use App\Services\Factries\ExternalResponse\Base;

/**
 * First hierarchy
 *
 * @author Yuta Aoki
 */
class First extends Base
{
    /**
     * Format the response
     *
     * @return ?array
     */
    public function formatResponse() : ?array
    {
        $response = json_decode($this->response->getBody(), true);
        $feature = $response[$this->addedResponse['response']];
        $this->addResponse($feature);
        $this->add_processed_response();
        return $this->data;
    }

    /**
     * Add response parameters
     *
     * @param int $index
     * @param array $value
     */
    private function addResponse(array $value) : void
    {
        foreach($this->addedResponse['key'] as $array) {
            $variable = $this->get_value($value, $array['content']);
            $this->data[$array['name']] = $variable;
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

    /**
     * Determine how to process and execute it
     *
     * @return void
     */
    private function add_processed_response() : void
    {
        if (array_key_exists('processing', $this->addedResponse)) {
            foreach($this->addedResponse['processing'] as $array) {
                $this->data[$array['name']] =
                    $array['type'] === self::PROCESSING['RATING']
                    ? $this->get_rating((float)$this->data[$array['key_name']])
                    : false;
            }
        }
    }
}
