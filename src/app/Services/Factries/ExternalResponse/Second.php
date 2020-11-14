<?php

namespace App\Services\Factries\ExternalResponse;

use App\Services\Factries\ExternalResponse\Base;

/**
 * Second hierarchy
 *
 * @author Yuta Aoki
 */
class Second extends Base
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
        foreach($feature as $index => $value) {
            $this->addResponse($index, $value);
            $this->add_processed_response($index);
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
            $this->data[$index][$array['name']] = $variable;
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
     * @param int $index
     * @return void
     */
    private function add_processed_response(int $index) : void
    {
        if (array_key_exists('processing', $this->addedResponse)) {
            foreach($this->addedResponse['processing'] as $array) {
                $this->data[$index][$array['name']] =
                    $array['type'] === self::PROCESSING['RATING']
                    ? $this->get_rating((float)$this->data[$index][$array['key_name']])
                    : false;
            }
        }
    }
}
