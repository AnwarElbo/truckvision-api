<?php

namespace Xolvio\TruckvisionApi\Transaction;

class Other
{
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

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var string
     */
    private $other_identifier;

    public function __construct(
        string $external_remark,
        string $internal_remark,
        string $layer,
        int $quantity,
        string $other_identifier
    ) {

        $this->external_remark   = $external_remark;
        $this->internal_remark   = $internal_remark;
        $this->layer             = $layer;
        $this->quantity          = $quantity;
        $this->other_identifier  = $other_identifier;
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

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getOtherIdentifier(): string
    {
        return $this->other_identifier;
    }
}