<?php

namespace Xolvio\TruckvisionApi\Response;

use Xolvio\TruckvisionApi\TruckvisionResponseInterface;

class StopWebClockResponse implements TruckvisionResponseInterface
{
    /**
     * @var \SimpleXMLElement
     */
    private $element;

    public function __construct(\SimpleXMLElement $element)
    {
        $this->element = $element;
    }
}
