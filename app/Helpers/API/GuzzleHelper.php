<?php

namespace App\Helpers\API;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GuzzleHelper
{
    public function get($requests)
    {
        $client = new Client([
            'base_uri' => config('api.url'),
            'headers' => $this->apiHeaders(),
            'http_errors' => false
        ]);

        $promises = [];
        $requestIndexCheck = '';

        foreach ($requests as $request => $path) {
            $promises[$request] = $client->getAsync($path);
            $requestIndexCheck = $request;
        }

        $responses = Promise\unwrap($promises);

        // Check if still authenticated
        $this->isAuthenticated($responses[$requestIndexCheck]->getStatusCode());

        return Promise\unwrap($promises);
    }

    private function apiHeaders()
    {
        return [
            'x-access-token' => session('token'),
            'Accept' => 'application/json',
        ];
    }

    private function isAuthenticated($responseCode)
    {
        if ($responseCode != '200') {
            Auth::logout();
        }
    }

    public function post($request, $body)
    {
        $client = new Client();

        $URI = config('api.url') . $request;

        try {
            $response = $client->request('POST', $URI, [
                'headers' => $this->apiHeaders(),
                'json' => $body,
            ]);
        } catch (GuzzleException $e) {
            if ($e->getCode() == '401') {
                return '401';
            }
            if ($e->getCode() == '404') {
                return '404';
            }
            abort('500');
        }

        // Check if still authenticated
        $this->isAuthenticated($response->getStatusCode());

        $res = $response->getBody()->getContents();

        if (Str::contains($res, '[]')) {
            return false;
        }

        return json_decode($res);
    }

    public function put($request, $body)
    {
        $client = new Client();

        $URI = config('api.url') . $request;

        try {
            $response = $client->request('PUT', $URI, [
                'headers' => $this->apiHeaders(),
                'json' => $body,
                'http_errors' => false
            ]);

        } catch (GuzzleException $e) {
            abort('500');
        }

        // Check if still authenticated
        $this->isAuthenticated($response->getStatusCode());

        return true;
    }

    private function apiClient($headers)
    {
        return new Client([
            'base_uri' => config('api.url'),
            'headers' => $this->apiHeaders(),
            'http_errors' => false
        ]);
    }
}
