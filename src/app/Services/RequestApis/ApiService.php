<?php

namespace App\Services\RequestApis;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class ApiService
{
    public function __construct(string $method, string $end_point, array $options)
    {
        $this->method = $method;
        $this->end_point = $end_point;
        $this->options = $options;
    }

    /**
     * Call API with Guzzle
     *
     * @return void
     */
    public function request(): ResponseInterface
    {
        $client = new Client();
        try {
            return $client->request($this->method, $this->end_point, $this->options);
        } catch (ClientException $e) {
            throw new ClientException($e->getMessage(), $e->getCode());
        } catch (ServerException $e) {
            throw new ServerException($e->getMessage(), $e->getCode());
        } catch (ConnectException $e) {
            throw new ConnectException($e->getMessage(), $e->getCode());
        } catch (RequestException $e) {
            throw new RequestException($e->getMessage(), $e->getCode());
        }
    }
}
