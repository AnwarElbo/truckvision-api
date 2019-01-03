<?php

namespace Xolvio\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Xolvio\TruckvisionApi\Requests\StartWebClock;
use Xolvio\TruckvisionApi\TruckvisionApi;
use Xolvio\TruckvisionApi\TruckvisionRequestTemplate;

class TruckvisionApiTest extends TestCase
{
    /**
     * @var TruckvisionApi
     */
    private $truckvision_api;

    public function setUp()
    {
        dd($this->getMockFromWsdl(__DIR__ . '/../src/WSDL/V3.xml'));
        $this->truckvision_api = new TruckvisionApi();
    }

    public function test_start_web_clock_call()
    {
        dd($this->truckvision_api);
    }
}