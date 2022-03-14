<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class ApiService
{
    /**
     * Call API with Guzzle
     *
     * @param string $method
     * @param string $end_point
     * @param array $options
     * @return void
     */
    public function request(string $method, string $end_point, array $options): ResponseInterface
    {
        $client = new Client();
        try {
            return $client->request($method, $end_point, $options);
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
