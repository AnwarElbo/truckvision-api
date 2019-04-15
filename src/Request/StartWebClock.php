<?php

namespace Xolvio\TruckvisionApi\Request;

use DateTime;
use Xolvio\TruckvisionApi\Response\StartWebClockResponse;
use Xolvio\TruckvisionApi\TruckvisionApi;
use Xolvio\TruckvisionApi\TruckvisionRequestInterface;
use Xolvio\TruckvisionApi\TruckvisionResponseInterface;

class StartWebClock implements TruckvisionRequestInterface
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
    private $mechanic_number;

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
        int $mechanic_number,
        DateTime $start,
        string $username,
        string $order_number = '',
        string $improductivity_code = '',
        string $language_code = 'NL'
    ) {
        $this->request_template    = new RequestTemplate();
        $this->improductivity_code = $improductivity_code;
        $this->language_code       = $language_code;
        $this->mechanic_number     = $mechanic_number;
        $this->order_number        = $order_number;
        $this->start               = $start;
        $this->username            = $username;
        $this->branch
    }

    /**
     * @return string
     */
    public function build(): string
    {
        $body = [
            'v' . TruckvisionApi::VERSION . ':StartWebklok' => [
                'v' . TruckvisionApi::VERSION . ':request' => [
                    'dos:ImproductivityCode' => $this->improductivity_code,
                    'dos:LanguageCode'       => $this->language_code,
                    'dos:MechanicNumber'     => $this->mechanic_number,
                    'dos:OrderNumber'        => $this->order_number,
                    'dos:Start'              => $this->start->format('c'),
                    'dos:UserName'           => $this->username,
                ],
            ],
        ];

        $this->request_template->setBody($body);

        return $this->request_template->toString();
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return '/dossierservice/V' . TruckvisionApi::VERSION . '/IDossier/StartWebklok';
    }

    /**
     * @param \SimpleXMLElement $xml
     *
     * @return TruckvisionResponseInterface
     */
    public function setResponse(\SimpleXMLElement $xml): TruckvisionResponseInterface
    {
        return new StartWebClockResponse($xml);
    }
}
