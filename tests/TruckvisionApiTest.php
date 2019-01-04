<?php

namespace Xolvio\Tests;

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
        $this->truckvision_api = new TruckvisionApi('~/Services/DossierService/V3/Dossier.svc');
    }

    public function test_start_web_clock_call()
    {
        $request = new StartWebClock(
            new RequestTemplate(),
            'VG',
            'NL',
            201,
            '20180416668',
            '20180419 143829',
            'Gebruiker'
        );

        dd($this->truckvision_api->request($request)->send());
    }
}
