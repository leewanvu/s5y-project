<?php

namespace App\ApfApi;

use GuzzleHttp\Client;

abstract class BaseApi
{
    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $secretKey;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    protected $apiVersion = '2020-01';

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('shopify.api_key');
        $this->secretKey = config('shopify.secret_key');
    }
}
