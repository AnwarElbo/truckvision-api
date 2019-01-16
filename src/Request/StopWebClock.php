<?php

namespace Xolvio\TruckvisionApi\Request;

use DateTime;
use Xolvio\TruckvisionApi\Response\StopWebClockResponse;
use Xolvio\TruckvisionApi\Transaction\TransactionCollection;
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
     * @var string
     */
    private $username;

    /**
     * @var TransactionCollection
     */
    private $transaction_collection;

    /**
     * @var int
     */
    private $clocking_id;

    /**
     * @var DateTime
     */
    private $stop;

    public function __construct(
        int $clocking_id,
        DateTime $stop,
        string $username,
        ?TransactionCollection $transaction_collection = null,
        string $language_code = 'NL'
    ) {
        $this->request_template       = new RequestTemplate();
        $this->transaction_collection = $transaction_collection ?? new TransactionCollection();
        $this->clocking_id            = $clocking_id;
        $this->language_code          = $language_code;
        $this->username               = $username;
        $this->stop                   = $stop;
    }

    /**
     * @return string
     */
    public function build(): string
    {
        $request = [
            'dos:KlokkingId'          => $this->clocking_id,
            'dos:LanguageCode'        => $this->language_code,
            'dos:Stop'                => $this->stop->format('c'),
            'dos:UserName'            => $this->username,
        ];

        if (! $this->transaction_collection->isEmpty()) {
            $request['dos:WebklokTransactions'] = $this->transaction_collection->toArray();
        }

        $body = [
            'v3:StopWebklok' => [
                'v3:request' => $request,
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
        return '/dossierservice/V3/IDossier/StopWebklok';
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
