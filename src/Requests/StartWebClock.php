<?php

namespace Xolvio\TruckvisionApi\Requests;

use Xolvio\TruckvisionApi\TruckvisionRequestInterface;

class StartWebClock implements TruckvisionRequestInterface
{
    /**
     * @return string
     */
    public function build(\SoapClient $client): string
    {
		dd($client->StartWebklok([
			'ImproductivityCode' => 'VG',
			'LanguageCode' => 'NL',
			'MechanicNumber' => 201,
			'OrderNumber' => '',
			'Start' => '20180419 188536',
			'UserName' => 'Test'
		]));
    }
}