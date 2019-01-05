<?php

namespace Xolvio\TruckvisionApi\Response;

use Xolvio\TruckvisionApi\Exceptions\TruckvisionApiResponseExceptionHandler;
use Xolvio\TruckvisionApi\TruckvisionResponseInterface;

class StopWebClockResponse implements TruckvisionResponseInterface
{
    /**
     * @var string
     */
    private const RESPONSE = 'StopWebklokResponse';

    /**
     * @var string
     */
    private const RESULT = 'StopWebklokResult';

    /**
     * @var \SimpleXMLElement
     */
    private $content;

    /**
     * @var array
     */
    private $namespaces;

    /**
     * StopWebClockResponse constructor.
     *
     * @param \SimpleXMLElement $content
     *
     * @throws \Xolvio\TruckvisionApi\Exceptions\TruckvisionApiException
     */
    public function __construct(\SimpleXMLElement $content)
    {
        $this->content    = $content;
        $this->namespaces = $content->getNamespaces(true);

        TruckvisionApiResponseExceptionHandler::handle($this->getBody(), $this->namespaces);
    }

    private function getBody(): \SimpleXMlElement
    {
        return $this->content
            ->children($this->namespaces['s'])
            ->Body
            ->children()
            ->{self::RESPONSE}
            ->{self::RESULT};
    }
}
