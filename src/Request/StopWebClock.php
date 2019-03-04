<?php

namespace Xolvio\TruckvisionApi\Request;

use DateTime;
use Xolvio\TruckvisionApi\Response\StopWebClockResponse;
use Xolvio\TruckvisionApi\Transaction\TransactionCollection;
use Xolvio\TruckvisionApi\TruckvisionApi;
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
    private $language_code;

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
    /**
     * @var float
     */
    private $break_time;

    public function __construct(
        int $clocking_id,
        DateTime $stop,
        string $username,
        float $break_time = 0,
        ?TransactionCollection $transaction_collection = null,
        string $language_code = 'NL'
    ) {
        $this->request_template       = new RequestTemplate();
        $this->clocking_id            = $clocking_id;
        $this->stop                   = $stop;
        $this->username               = $username;
        $this->break_time             = $break_time;
        $this->language_code          = $language_code;
        $this->transaction_collection = $transaction_collection ?? new TransactionCollection();
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

        if ($this->break_time > 0) {
            $request['dos:BreakTime'] = $this->break_time;
        }

        $body = [
            'v' . TruckvisionApi::VERSION . ':StopWebklok' => [
                'v' . TruckvisionApi::VERSION . ':request' => $request,
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
        return '/dossierservice/V' . TruckvisionApi::VERSION . '/IDossier/StopWebklok';
    }

    /**
     * @param \SimpleXMLElement $element
     *
     * @throws \Xolvio\TruckvisionApi\Exceptions\TruckvisionApiException
     *
     * @return TruckvisionResponseInterface
     */
    public function setResponse(\SimpleXMLElement $element): TruckvisionResponseInterface
    {
        return new StopWebClockResponse($element);
    }
}
