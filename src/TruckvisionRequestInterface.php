<?php

namespace Xolvio\TruckvisionApi;

interface TruckvisionRequestInterface
{
    /**
     * @return string
     */
    public function build(): string;

    /**
     * @return string
     */
    public function getAction(): string;

    /**
     * @param \SimpleXMLElement $element
     *
     * @return TruckvisionResponseInterface
     */
    public function setResponse(\SimpleXMLElement $element): TruckvisionResponseInterface;
}
