<?php

namespace Xolvio\TruckvisionApi\Requests;

use Spatie\ArrayToXml\ArrayToXml;

class RequestTemplate
{
    /**
     * @var array
     */
    private $body;

    /**
     * @return array
     */
    private function getHeader(): array
    {
        return [];
    }

    /**
     * @param array $body
     */
    public function setBody(array $body): void
    {
        $this->body = $body;
    }

    /**
     * @return array
     */
    public function getBody(): array
    {
        return [$this->body];
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return ArrayToXml::convert(['soapenv:Header' => $this->getHeader(), 'soapenv:Body' => $this->getBody()], [
            'rootElementName' => 'soapenv:Envelope',
            '_attributes'     => [
                'xmlns:soapenv' => 'http://schemas.xmlsoap.org/soap/envelope/',
                'xmlns:dos'     => 'http://relead.nl/dossierservice',
                'xmlns:v3'      => 'http://relead.nl/dossierservice/V3',
            ],
        ]);
    }
}
