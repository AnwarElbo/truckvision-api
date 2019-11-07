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

        TruckvisionApiResponseExceptionHandler::handle($this, $this->namespaces);
    }

    /**
     * @return string
     */
    public function getStatusCode(): string
    {
        return (string) $this->getBody()->children($this->namespaces['a'])->ReturnCode;
    }

    /**
     * @return int
     */
    public function getClockingId(): int
    {
        return (int) $this->getBody()->children($this->namespaces['a'])->KlokkingId;
    }

    /**
     * @return \SimpleXMLElement
     */
    public function getBody(): \SimpleXMLElement
    {
        return $this->content
            ->children($this->namespaces['s'])
            ->Body
            ->children()
            ->{self::RESPONSE}
            ->{self::RESULT};
    }

    /**
     * @return array
     */
    public function getNamespaces(): array
    {
        return $this->namespaces;
    }

    /**
     * @return string
     */
    public function getErrorString(): string
    {
        return (string) 
            $this->getBody()
            ->children($this->namespaces['a'])
            ->ErrorMessages
            ->children($this->namespaces['b'])
            ->string;
    }
}
