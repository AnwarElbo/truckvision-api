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
		$start_web_clock_request = new \StdClass();
		$start_web_clock_request->ImproductivityCode = 'VG';
		$start_web_clock_request->LanguageCode = 'NL';
		$start_web_clock_request->MechanicNumber = 201;
		$start_web_clock_request->OrderNumber = '';
		$start_web_clock_request->Start = '20180419 188536';
		$start_web_clock_request->UserName = 'Test';
		
		try {
			dd($client->__getTypes());
			$client->StartWebklok(null, 'VG', 'NL');
		} catch (\Exception $e) {
			dd($client->__getLastRequest());
		}
	}
}