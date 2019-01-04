<?php

namespace Xolvio\Tests;

use Artisaninweb\SoapWrapper\Service;
use Artisaninweb\SoapWrapper\SoapWrapper;
use PHPUnit\Framework\TestCase;
use Xolvio\TruckvisionApi\Soap\Request\StartWebClockRequest;
use Xolvio\TruckvisionApi\Soap\Response\StartWebClockResponse;
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
        $soap = new SoapWrapper();
        $soap->add('truckvision', function (Service $service) {
            $service->wsdl(__DIR__ . '/../src/wsdl/v3.xml')
                ->trace(true)
                ->classMap([
                    StartWebClockRequest::class,
                    StartWebClockResponse::class,
                ]);
        });

        dd($soap->call('truckvision.StartWebKlok', [
            new StartWebClockRequest('', 'VG', 'NL', 'WO20180702069501', '20190104', 'Test!'),
        ]));
    }
}
