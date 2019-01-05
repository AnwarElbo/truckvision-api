<?php

namespace Xolvio\Tests;

use DateTime;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Xolvio\TruckvisionApi\Exceptions\TruckvisionApiException;
use Xolvio\TruckvisionApi\Request\RequestTemplate;
use Xolvio\TruckvisionApi\Request\StartWebClock;
use Xolvio\TruckvisionApi\TruckvisionApi;

class TruckvisionApiTest extends TestCase
{
    /**
     * @var TruckvisionApi
     */
    private $truckvision_api;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $end_point;

    /**
     * @var string
     */
    private $requests;

    public function setUp()
    {
        $this->requests = [
            'error_start_web_clock_response'   => file_get_contents(__DIR__ . '/responses/error_start_web_clock_response.xml'),
            'success_start_web_clock_response' => file_get_contents(__DIR__ . '/responses/success_start_web_clock_response.xml'),
        ];

        $this->client    = $this->prophesize(ClientInterface::class);
        $this->end_point = 'http://truckvisiontest.sentwaninge.com/Services/DossierService/V3/Dossier.svc';

        $this->truckvision_api = new TruckvisionApi(
            $this->client->reveal(),
            $this->end_point
        );
    }

    public function test_error_start_web_clock_call(): void
    {
        $this->expectException(TruckvisionApiException::class);
        $this->expectExceptionMessage('Er is geen licentie gevonden voor dit maatwerk');

        $this->mockRequest('error_start_web_clock_response');

        $request = new StartWebClock(
            new RequestTemplate(),
            4001,
            '20180416668',
            new DateTime('2019-01-06 07:45'),
            'Gebruiker'
        );

        $this->truckvision_api->request($request)->send();
    }

    public function test_success_start_web_clock_call(): void
    {
        $this->mockRequest('success_start_web_clock_response');

        $request = new StartWebClock(
            new RequestTemplate(),
            4001,
            '20180416668',
            new DateTime('2019-01-06 07:45'),
            'Gebruiker'
        );

        $this->assertSame(
            31245,
            $this->truckvision_api->request($request)->send()->getClockingId()
        );
    }

    private function mockRequest(string $request): void
    {
        $body = $this->prophesize(StreamInterface::class);
        $body->getContents()->willReturn($this->requests[$request]);

        $response = $this->prophesize(ResponseInterface::class);
        $response->getBody()->willReturn($body->reveal());

        $this->client->request('POST', $this->end_point, Argument::type('array'))->willReturn($response->reveal());
    }
}
