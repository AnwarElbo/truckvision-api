<?php

namespace Xolvio\TruckvisionApi\Request;

use DateTime;
use Xolvio\TruckvisionApi\Response\StartWebClockResponse;
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
        DateTime $start,
        string $username,
        string $order_number = '',
        string $improductivity_code = 'VG',
        string $language_code = 'NL'
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
        $body = [
            'v3:StartWebklok' => [
                'v3:request' => [
                    'dos:ImproductivityCode' => $this->improductivity_code,
                    'dos:LanguageCode'       => $this->language_code,
                    'dos:MechanicCode'       => $this->mechanic_code,
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
        return '/dossierservice/V3/IDossier/StartWebklok';
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
