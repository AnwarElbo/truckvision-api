<?php

namespace Xolvio\TruckvisionApi\Response;

use SimpleXMLElement;
use Xolvio\TruckvisionApi\TruckvisionResponseInterface;

class ChangeTransactionProcessIdResponse implements TruckvisionResponseInterface
{
    private const RESPONSE = 'ChangeTransactionProcessIdResponse';
    private const RESULT   = 'ChangeTransactionProcessIdResult';

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
    public function getFileTransactionId(): int
    {
        return (int) $this->getBody()->children($this->namespaces['a'])->FileTransactionId;
    }
}