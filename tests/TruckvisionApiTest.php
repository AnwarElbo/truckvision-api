<?php

namespace Xolvio\Tests;

use DateTime;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Xolvio\TruckvisionApi\Exceptions\ResponseExceptions\TruckvisionApiMechanicHasClockingOpenException;
use Xolvio\TruckvisionApi\Exceptions\ResponseExceptions\TruckvisionApiNoLicenseException;
use Xolvio\TruckvisionApi\Request\RequestTemplate;
use Xolvio\TruckvisionApi\Request\StartWebClock;
use Xolvio\TruckvisionApi\Request\StopWebClock;
use Xolvio\TruckvisionApi\Transaction\Transaction;
use Xolvio\TruckvisionApi\Transaction\TransactionCollection;
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
            'error_no_license_start_web_clock_response'                 => file_get_contents(__DIR__ . '/responses/error_no_license_start_web_clock_response.xml'),
            'success_start_web_clock_response'                          => file_get_contents(__DIR__ . '/responses/success_start_web_clock_response.xml'),
            'error_mechanic_has_clocking_open_start_web_clock_response' => file_get_contents(__DIR__ . '/responses/error_mechanic_has_clocking_open_start_web_clock_response.xml'),
            'success_stop_web_clock_response'                           => file_get_contents(__DIR__ . '/responses/success_stop_web_clock_response.xml'),
        ];

        $this->client    = $this->prophesize(ClientInterface::class);
        $this->end_point = 'http://truckvisiontest.sentwaninge.com/Services/DossierService/V3/Dossier.svc';

        $this->truckvision_api = new TruckvisionApi(
            $this->client->reveal(),
            $this->end_point
        );
    }

    /** @test */
    public function no_license_start_web_clock_call(): void
    {
        $this->expectException(TruckvisionApiNoLicenseException::class);
        $this->expectExceptionMessage('Er is geen licentie gevonden voor dit maatwerk');

        $this->mockRequest('error_no_license_start_web_clock_response');

        $request = new StartWebClock(
            new RequestTemplate(),
            4001,
            '20180416668',
            new DateTime('2019-01-06 07:45'),
            'User'
        );

        $this->truckvision_api->request($request)->send();
    }

    /** @test */
    public function mechanic_has_clocking_open_start_web_clock(): void
    {
        $this->expectException(TruckvisionApiMechanicHasClockingOpenException::class);
        $this->expectExceptionMessage('Er staat voor deze monteur al een klokking open');

        $this->mockRequest('error_mechanic_has_clocking_open_start_web_clock_response');

        $request = new StartWebClock(
            new RequestTemplate(),
            4001,
            '2012913023',
            new DateTime('2019-01-06 07:54'),
            'User'
        );

        $this->truckvision_api->request($request)->send();
    }

    /** @test */
    public function success_start_web_clock_call(): void
    {
        $this->mockRequest('success_start_web_clock_response');

        $request = new StartWebClock(
            new RequestTemplate(),
            4001,
            '20180416668',
            new DateTime('2019-01-06 07:45'),
            'User'
        );

        $response = $this->truckvision_api->request($request)->send();

        $this->assertSame(
            1056511,
            $response->getClockingId()
        );

        $this->assertSame('OK', $response->getStatusCode());
    }

    /** @test */
    public function success_stop_web_clock_all(): void
    {
        $this->mockRequest('success_stop_web_clock_response');

        $transaction_collection = new TransactionCollection();

        $transaction_collection->add(new Transaction(0.25, 22222));
        $transaction_collection->add(new Transaction(1.04, 482984));
        $transaction_collection->add(new Transaction(2.10, 18923));
        $transaction_collection->add(new Transaction(3.75, 93842));
        $transaction_collection->add(new Transaction(4.50, 983298));

        $request = new StopWebClock(
            new RequestTemplate(),
            $transaction_collection,
            912019,
            new DateTime('2019-01-05 04:33'),
            'User'
        );

       self::assertSame('OK', $this->truckvision_api->request($request)->send()->getStatusCode());
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
