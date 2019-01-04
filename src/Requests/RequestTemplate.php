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
     * @param array  $body
     * @param string $namespace
     *
     * @return array
     */
    private function setNamespace(array $body, string $namespace): array
    {
        return collect($body)->mapWithKeys(function ($value, $key) use ($namespace) {
            if (is_array($value)) {
                $value = $this->setNamespace($value, $namespace);
            }

            return [$namespace . ':' . $key => $value];
        })->toArray();
    }

    /**
     * @param array  $body
     * @param string $namespace
     */
    public function setBody(array $body, string $namespace = ''): void
    {
        if ('' !== $namespace) {
            $body = $this->setNamespace($body, $namespace);
        }

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
        return ArrayToXml::convert(['soapEnv:Header' => $this->getHeader(), 'soapEnv:Body' => $this->getBody()], [
            'rootElementName' => 'soapenv:Envelope',
            '_attributes'     => [
                'xmlns:soapenv' => 'http://schemas.xmlsoap.org/soap/envelope/',
                'xmlns:dos'     => 'http://relead.nl/dossierservice',
            ],
        ]);
    }
}
