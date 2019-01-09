<?php

namespace Xolvio\TruckvisionApi\Transaction;

class Transaction
{
    /**
     * @var float
     */
    private $hours;

    /**
     * @var int
     */
    private $dossier_verrichting_id;

    public function __construct(
        float $hours,
        int $dossier_verrichting_id
    ) {
        $this->hours                  = $hours;
        $this->dossier_verrichting_id = $dossier_verrichting_id;
    }

    /**
     * @return int
     */
    public function getHours(): float
    {
        return $this->hours;
    }

    /**
     * @return int
     */
    public function getDossierVerrichtingId(): int
    {
        return $this->dossier_verrichting_id;
    }
}
