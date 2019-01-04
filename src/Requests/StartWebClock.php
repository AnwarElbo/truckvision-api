<?php

namespace Xolvio\TruckvisionApi\Requests;

use Xolvio\TruckvisionApi\TruckvisionRequestInterface;

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
     * @var string
     */
    private $start;

    /**
     * @var string
     */
    private $username;

    public function __construct(
        RequestTemplate $request_template,
        string $improductivity_code,
        string $language_code,
        int $mechanic_code,
        string $order_number,
        string $start,
        string $username
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
        $request = [
            'StartWebKlok' => [
                'request' => [
                    'ImproductivityCode' => $this->improductivity_code,
                    'LanguageCode'       => $this->language_code,
                    'MechanicCode'       => $this->mechanic_code,
                    'OrderNumber'        => $this->order_number,
                    'Start'              => $this->start,
                    'UserName'           => $this->username,
                ],
            ],
        ];

        $this->request_template->setBody($request, 'dos');

        return $this->request_template->toString();
    }
}
