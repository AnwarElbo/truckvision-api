<?php

namespace Xolvio\TruckvisionApi\Response;

use Xolvio\TruckvisionApi\Exceptions\TruckvisionApiResponseExceptionHandler;
use Xolvio\TruckvisionApi\TruckvisionResponseInterface;

class StartWebClockResponse implements TruckvisionResponseInterface
{
    /**
     * @var string
     */
    private const RESPONSE = 'StartWebklokResponse';

    /**
     * @var string
     */
    private const RESULT = 'StartWebklokResult';

    /**
     * @var \SimpleXMLElement
     */
    private $content;

    /**
     * @var array
     */
    private $namespaces;

    public function __construct(\SimpleXMLElement $content)
    {
        $this->content    = $content;
        $this->namespaces = $content->getNamespaces(true);

        TruckvisionApiResponseExceptionHandler::handle($this->getBody(), $this->namespaces);
    }

    /**
     * @return \SimpleXMLElement
     */
    private function getBody(): \SimpleXMLElement
    {
        return $this->content
            ->children($this->namespaces['s'])
            ->Body
            ->children()
            ->{self::RESPONSE}
            ->{self::RESULT};
    }

    /**
     * @return int
     */
    public function getClockingId(): int
    {
        return (int) $this->getBody()->children($this->namespaces['a'])->KlokkingId;
    }
}
