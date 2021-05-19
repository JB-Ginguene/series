<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    public $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getRandomJoke(): array
    {
        $response = $this->client->request(
            'GET',
            'https://official-joke-api.appspot.com/random_joke'
        );
        return $response->toArray();
    }
}