<?php

namespace Xolvio\TruckvisionApi\Transaction;

use Illuminate\Support\Collection;
use Xolvio\TruckvisionApi\TruckvisionCollectionInterface;

class TransactionCollection implements TruckvisionCollectionInterface
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
    public function toXmlArray(): array
    {
        $transactions = ['dos:WebklokTransaction' => $this->transactions->map(
            static function (Transaction $transaction) {
                return [
                    'dos:FileTransactionId' => $transaction->getDossierVerrichtingId(),
                    'dos:Hours'             => $transaction->getHours(),
                ];
            })->toArray(),
        ];

        return $transactions;
    }

    /**
     * @return Collection
     */
    public function toCollection(): Collection
    {
        return $this->transactions;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->transactions->isEmpty();
    }
}
