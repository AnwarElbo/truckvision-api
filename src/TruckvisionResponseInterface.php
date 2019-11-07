<?php

namespace Xolvio\TruckvisionApi;

interface TruckvisionResponseInterface
{
    /**
     * @return string
     */
    public function getStatusCode(): string;

    /**
     * @return \SimpleXMLElement
     */
    public function getBody(): \SimpleXMLElement;

    /**
     * @return array
     */
    public function getNamespaces(): array;

    /**
     * @return string
     */
    public function getErrorString(): string;
}
