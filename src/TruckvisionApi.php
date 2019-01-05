<?php

namespace Xolvio\TruckvisionApi;

use GuzzleHttp\ClientInterface;
use Xolvio\TruckvisionApi\Exceptions\TruckvisionApiConnectionException;
use Xolvio\TruckvisionApi\Exceptions\TruckvisionApiNoResponseException;
use Xolvio\TruckvisionApi\Exceptions\TruckvisionApiXmlParseException;

class TruckvisionApi
{
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
     * @throws TruckvisionApiXmlParseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return \SimpleXMLElement
     */
    public function send(array $options = []): \SimpleXMLElement
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

        if ('' === $response) {
            throw new TruckvisionApiNoResponseException('No response called ' . $this->end_point . ' with the following XML: ' . $this->xml);
        }

        if (! $parsed_response = simplexml_load_string($response)) {
            throw new TruckvisionApiXmlParseException('Response: ' . $response . '. Couldn\'t get parsed by SimpleXml.');
        }

        return $parsed_response;
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
