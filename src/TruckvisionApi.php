<?php

namespace Xolvio\TruckvisionApi;

use Xolvio\TruckvisionApi\Exceptions\TruckvisionApiConnectionException;
use Xolvio\TruckvisionApi\Exceptions\TruckvisionApiNoResponseException;
use Xolvio\TruckvisionApi\Exceptions\TruckvisionApiXmlParseException;

class TruckvisionApi
{
    /**
     * @var string
     */
    private $end_point;

    /**
     * @var string
     */
    private $request;

    public function __construct(string $end_point)
    {
        $this->end_point = $end_point;
    }

    /**
     * @param TruckvisionRequestInterface $request
     *
     * @return TruckvisionApi
     */
    public function request(TruckvisionRequestInterface $request): self
    {
        $this->request = $request->build();

        return $this;
    }

    /**
     * @param array $options
     *
     * @throws TruckvisionApiConnectionException
     * @throws TruckvisionApiXmlParseException
     * @throws TruckvisionApiNoResponseException
     *
     * @return \SimpleXMLElement
     */
    public function send(array $options = []): \SimpleXMLElement
    {
        $connection = curl_init($this->end_point);

        curl_setopt($connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($connection, CURLOPT_TIMEOUT, $options['timeout'] ?? 10);
        curl_setopt($connection, CURLOPT_POST, true);
        curl_setopt($connection, CURLOPT_POSTFIELDS, $this->request);
        curl_setopt($connection, CURLOPT_HTTPHEADER, $this->getHeaders());

        try {
            $response = curl_exec($connection);
        } catch (\Exception $e) {
            throw new TruckvisionApiConnectionException($e->getMessage(), $e->getCode(), $e);
        } finally {
            curl_close($connection);
        }

        if (0 === strlen($response)) {
            throw new TruckvisionApiNoResponseException('No response called ' . $this->end_point . ' with the following XML: ' . $this->request);
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
            'Content-type: text/xml;charset="utf-8"',
            'Accept: text/xml',
            'Cache-Control: no-cache',
            'Pragma: no-cache',
            'Content-length: ' . strlen($this->request),
        ];
    }
}
