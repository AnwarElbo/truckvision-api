<?php

namespace Xolvio\TruckvisionApi;

use GuzzleHttp\ClientInterface;

class TruckvisionApi
{
    /**
     * @var \SoapClient
     */
    private $client;

    public function __construct(string $wsdl_version = 'V3')
    {
        $this->client = new \SoapClient(__DIR__ . '/WSDL/' . $wsdl_version . '.xml', [
            'trace' => 1
        ]);
    }

    public function request(TruckvisionRequestTemplate $request)
    {

    }
}