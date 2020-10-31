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
        $headers = $this->apiHeaders();

        $client = $this->apiClient($headers);

        $promises = [];
        $requestIndexCheck = '';

        foreach ($requests as $request => $path) {
            $promises[$request] = $client->getAsync($path);
            $requestIndexCheck = $request;
        }

        $responses = Promise\unwrap($promises);

        // Check if still authenticated
        $responseCode = json_decode($responses[$requestIndexCheck]->getStatusCode());

        if ($responseCode != '200') {
            Auth::logout();
        }

        return Promise\unwrap($promises);
    }

    public function post($request, $body)
    {
        $headers = $this->apiHeaders();

        $client = new Client();

        $URI = config('api.url') . $request;

        try {
            $response = $client->request('POST', $URI, [
                'headers' => $headers,
                'json' => $body,
            ]);
        } catch (GuzzleException $e) {
            abort('500');
        }

        // Check if still authenticated
        $responseCode = $response->getStatusCode();
        if ($responseCode != '200') {
            Auth::logout();
        }

        $res = $response->getBody()->getContents();

        if (Str::contains($res, '[]')) {
            return false;
        }

        return json_decode($res);
    }

    public function put($request, $body)
    {
        $headers = $this->apiHeaders();

        $client = new Client();

        $URI = config('api.url') . $request;

        try {
            $response = $client->request('PUT', $URI, [
                'headers' => $headers,
                'json' => $body,
                'http_errors' => false
            ]);

        } catch (GuzzleException $e) {
            abort('500');
        }

        // Check if still authenticated
        $responseCode = $response->getStatusCode();

        if ($responseCode != '200') {
            Auth::logout();
        }

        return true;
    }

    private function apiHeaders()
    {
        return [
            'Accept' => 'application/json',
        ];
    }

    private function apiClient($headers)
    {
        return new Client([
            'base_uri' => config('api.url'),
            'headers' => $headers,
            'http_errors' => false
        ]);
    }
}
