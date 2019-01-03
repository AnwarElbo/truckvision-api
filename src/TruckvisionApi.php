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
        $this->client = new \SoapClient('http://truckvision.sentwaninge.com/Services/DossierService/' . $wsdl_version . '/Dossier.svc?wsdl', [
            'trace' => 1
        ]);
    }

    public function request(TruckvisionRequestInterface $request)
    {
		return $request->build($this->client);
    }
}