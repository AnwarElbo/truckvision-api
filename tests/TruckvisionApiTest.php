<?php

namespace Xolvio\Tests;

use DateTime;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Xolvio\TruckvisionApi\Requests\RequestTemplate;
use Xolvio\TruckvisionApi\Requests\StartWebClock;
use Xolvio\TruckvisionApi\TruckvisionApi;

class TruckvisionApiTest extends TestCase
{
    /**
     * @var TruckvisionApi
     */
    private $truckvision_api;

    public function setUp()
    {
        $this->truckvision_api = new TruckvisionApi(
            new Client(),
            'http://truckvisiontest.sentwaninge.com/Services/DossierService/V3/Dossier.svc'
        );
    }

    public function test_start_web_clock_call(): void
    {
        $request = new StartWebClock(
            new RequestTemplate(),
            'VG',
            'NL',
            4001,
            '20180416668',
            new DateTime('2019-01-06 07:45'),
            'Gebruiker'
        );

        dd($this->truckvision_api->request($request)->send());
    }
}
