<?php

namespace Xolvio\TruckvisionApi\Transaction;

use Illuminate\Support\Collection;

class TransactionCollection
{
    /**
     * @var Collection
     */
    private $transactions;

    public function __construct()
    {
        $this->transactions = collect();
    }

    /**
     * @param Transaction $transaction
     *
     * @return self
     */
    public function add(Transaction $transaction): self
    {
        $this->transactions->push($transaction);

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $transactions = ['dos:WebklokTransaction' => $this->transactions->map(
            function (Transaction $transaction) {
                return [
                    'dos:FileTransactionId' => $transaction->getDossierVerrichtingId(),
                    'dos:Hours'             => $transaction->getHours(),
                ];
            })->toArray(),
        ];

        return $transactions;
    }
}
