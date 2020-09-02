<?php

namespace App\Services\Wiki;

// Guzzleモジュールのクラス読み込み
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Services\ExternalResponse;

class GetCity extends ExternalResponse
{
    protected $addedResponse = [
        'key' => [
            ['name' => 'population', 'content' => "['claims']['P1082'][0]['mainsnak']['datavalue']['value']['amount']"],
            ['name' => 'area', 'content' => "['claims']['P2046'][0]['mainsnak']['datavalue']['value']['amount']"],
            ['name' => 'inception', 'content' => "['claims']['P571'][0]['mainsnak']['datavalue']['value']['time']"],
        ],
        'response' => 'entities',
    ];

    /**
     * Request to yahoo! local search API
     */
    public function apiRequest() {
        $client = new Client();
        $sourceUrl = "https://www.wikidata.org/wiki/Special:EntityData/".$this->request->wiki_id;
        $this->response = $client->request("GET", $sourceUrl);
    }

    /**
     * Format the response
     *
     * @return ?array
     */
    public function formatResponse() : ?array
    {
        $response = json_decode($this->response->getBody()->getContents(), true);
        $feature = $response[$this->addedResponse['response']][$this->request->wiki_id];
        $this->addResponse($feature);
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
            $this->organize_format($variable, $array);
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
     * Get a value from response data finding by especially key
     *
     * @param ?string $variable
     * @param string $array
     */
    private function organize_format(?string $variable, array $array)
    {
        if (isset($array['name'])) {
            if ($array['name'] === 'population') {
                $variable = (int) $variable;
            }
            if ($array['name'] === 'area') {
                $variable = round((float) $variable, 1);
            }
            if ($array['name'] === 'inception') {
                preg_match("/\+(.*)T.*Z/", $variable, $date);
                if (isset($date[1])) {
                    $variable = date('Y年m月d日', strtotime($date[1]));
                }
            }
        }
        $this->data['data'][$array['name']] = $variable;
    }
}
