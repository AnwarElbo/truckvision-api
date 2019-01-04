<?php

namespace Xolvio\TruckvisionApi\Soap\Request;

class StartWebClockRequest
{
    /**
     * @var string
     */
    protected $BrancheNumber;

    /**
     * @var string
     */
    protected $ImproductivityCode;

    /**
     * @var string
     */
    protected $LanguageCode;

    /**
     * @var string
     */
    protected $OrderNumber;

    /**
     * @var string
     */
    protected $Start;

    /**
     * @var string
     */
    protected $UserName;

    public function __construct(
        string $BrancheNumber,
        string $ImproductivityCode,
        string $LanguageCode,
        string $OrderNumber,
        string $Start,
        string $UserName
    ) {
        $this->BrancheNumber        = $BrancheNumber;
        $this->ImproductivityCode   = $ImproductivityCode;
        $this->LanguageCode         = $LanguageCode;
        $this->OrderNumber          = $OrderNumber;
        $this->Start                = $Start;
        $this->UserName             = $UserName;
    }

    /**
     * @return string
     */
    public function getBrancheNumber(): string
    {
        return $this->BrancheNumber;
    }

    /**
     * @return string
     */
    public function getImproductivityCode(): string
    {
        return $this->ImproductivityCode;
    }

    /**
     * @return string
     */
    public function getLanguageCode(): string
    {
        return $this->LanguageCode;
    }

    /**
     * @return string
     */
    public function getOrderNumber(): string
    {
        return $this->OrderNumber;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->UserName;
    }

    /**
     * @return string
     */
    public function getStart(): string
    {
        return $this->Start;
    }
}
