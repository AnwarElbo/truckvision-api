<?php

namespace Xolvio\TruckvisionApi\Response;

use Xolvio\TruckvisionApi\Exceptions\TruckvisionApiException;
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

        $this->handleExceptions();
    }

    /**
     * @throws TruckvisionApiException
     */
    private function handleExceptions(): void
    {
        $exception_message = $this->getBody()
            ->children($this->namespaces['a'])
            ->ErrorMessages;

        if ('' === (string) $exception_message) {
            return;
        }

        $exception_message = $exception_message->children($this->namespaces['b'])->string;

        throw new TruckvisionApiException($exception_message);
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
