<?php

namespace Xolvio\TruckvisionApi\Request;

use DateTime;
use Xolvio\TruckvisionApi\Response\StopWebClockResponse;
use Xolvio\TruckvisionApi\TruckvisionRequestInterface;
use Xolvio\TruckvisionApi\TruckvisionResponseInterface;

class StopWebClock implements TruckvisionRequestInterface
{
    /**
     * @var RequestTemplate
     */
    private $request_template;

    /**
     * @var string
     */
    private $improductivity_code;

    /**
     * @var string
     */
    private $language_code;

    /**
     * @var int
     */
    private $mechanic_code;

    /**
     * @var string
     */
    private $order_number;

    /**
     * @var DateTime
     */
    private $start;

    /**
     * @var string
     */
    private $username;

    public function __construct(
        RequestTemplate $request_template,
        int $mechanic_code,
        string $order_number,
        DateTime $start,
        string $username,
        string $language_code = 'NL',
        string $improductivity_code = 'VG'
    ) {
        $this->request_template    = $request_template;
        $this->improductivity_code = $improductivity_code;
        $this->language_code       = $language_code;
        $this->mechanic_code       = $mechanic_code;
        $this->order_number        = $order_number;
        $this->start               = $start;
        $this->username            = $username;
    }

    /**
     * @return string
     */
    public function build(): string
    {
        // TODO: Implement build() method.
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        // TODO: Implement getAction() method.
    }

    /**
     * @param \SimpleXMLElement $element
     *
     * @return TruckvisionResponseInterface
     */
    public function setResponse(\SimpleXMLElement $element): TruckvisionResponseInterface
    {
        return new StopWebClockResponse($element);
    }
}
