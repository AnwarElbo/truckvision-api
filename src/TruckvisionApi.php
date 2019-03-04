<?php

namespace Xolvio\TruckvisionApi;

use GuzzleHttp\ClientInterface;
use Xolvio\TruckvisionApi\Exceptions\TruckvisionApiConnectionException;
use Xolvio\TruckvisionApi\Exceptions\TruckvisionApiNoResponseException;

class TruckvisionApi
{
    /**
     * @var integer
     */
    public const VERSION = 4;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $end_point;

    /**
     * @var TruckvisionRequestInterface
     */
    private $request;

    /**
     * @var string
     */
    private $xml;

    public function __construct(ClientInterface $client, string $end_point)
    {
        $this->end_point = $end_point;
        $this->client    = $client;
    }

    /**
     * @param TruckvisionRequestInterface $request
     *
     * @return TruckvisionApi
     */
    public function request(TruckvisionRequestInterface $request): self
    {
        $this->request = $request;
        $this->xml     = $request->build();

        return $this;
    }

    /**
     * @param array $options
     *
     * @throws TruckvisionApiConnectionException
     * @throws TruckvisionApiNoResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return TruckvisionResponseInterface
     */
    public function send(array $options = []): TruckvisionResponseInterface
    {
        try {
            $response = $this->client->request('POST', $this->end_point, [
                'debug'   => $options['debug'] ?? false,
                'body'    => $this->xml,
                'headers' => $this->getHeaders(),
            ]);
        } catch (\Exception $e) {
            throw new TruckvisionApiConnectionException($e->getMessage(), $e->getCode(), $e);
        }

        $contents = $response->getBody()->getContents();

        if ('' === $contents) {
            throw new TruckvisionApiNoResponseException('No response called ' . $this->end_point . ' with the following XML: ' . $this->xml);
        }

        return $this->request->setResponse(new \SimpleXMLElement($contents));
    }

    /**
     * @return array
     */
    private function getHeaders(): array
    {
        return [
            'Content-type'   => 'text/xml;charset="utf-8"',
            'Accept'         => 'text/xml',
            'Cache-Control'  => 'no-cache',
            'Pragma'         => 'no-cache',
            'SoapAction'     => '"http://relead.nl' . $this->request->getAction() . '"',
            'Content-length' => strlen($this->xml),
        ];
    }
}
