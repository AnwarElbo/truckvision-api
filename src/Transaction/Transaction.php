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

    /**
     * @var string
     */
    private $external_remark;

    /**
     * @var string
     */
    private $internal_remark;

    /**
     * @var string
     */
    private $layer;

    public function __construct(
        float $hours,
        int $dossier_verrichting_id,
        string $external_remark = '',
        string $internal_remark = '',
        string $layer = ''
    ) {
        $this->hours                  = $hours;
        $this->dossier_verrichting_id = $dossier_verrichting_id;
        $this->external_remark        = $external_remark;
        $this->internal_remark        = $internal_remark;
        $this->layer                  = $layer;
    }

    /**
     * @return int
     */
    public function getHours(): int
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

    /**
     * @return string
     */
    public function getExternalRemark(): string
    {
        return $this->external_remark;
    }

    /**
     * @return string
     */
    public function getInternalRemark(): string
    {
        return $this->internal_remark;
    }

    /**
     * @return string
     */
    public function getLayer(): string
    {
        return $this->layer;
    }
}
