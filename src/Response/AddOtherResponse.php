<?php

namespace Xolvio\TruckvisionApi\Response;

use SimpleXMLElement;
use Xolvio\TruckvisionApi\TruckvisionResponseInterface;

class AddOtherResponse implements TruckvisionResponseInterface
{
    private const RESPONSE = 'AddOtherResponse';
    private const RESULT   = 'AddOtherResult';

    /**
     * @var SimpleXMLElement
     */
    private $content;

    /**
     * @var array
     */
    private $namespaces;

    public function __construct(SimpleXMLElement $content)
    {
        $this->content    = $content;
        $this->namespaces = $content->getNamespaces(true);
    }

    /**
     * @return string
     */
    public function getStatusCode(): string
    {
        return (string) $this->getBody()->children($this->namespaces['a'])->ReturnCode;
    }

    /**
     * @return SimpleXMLElement
     */
    public function getBody(): SimpleXMLElement
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
     * @return int
     */
    public function getFileOtherId(): int
    {
        return (int) $this->getBody()->children($this->namespaces['a'])->FileOtherId;
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