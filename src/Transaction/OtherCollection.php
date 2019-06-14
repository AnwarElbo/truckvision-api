<?php

namespace Xolvio\TruckvisionApi\Transaction;

use Illuminate\Support\Collection;
use Xolvio\TruckvisionApi\TruckvisionCollectionInterface;

class OtherCollection implements TruckvisionCollectionInterface
{
    /**
     * @var Collection
     */
    private $others;

    public function __construct()
    {
        $this->others = collect();
    }

    /**
     * @param Other $other
     *
     * @return OtherCollection
     */
    public function add(Other $other): self
    {
        $this->others->push($other);

        return $this;
    }

    /**
     * @return array
     */
    public function toXmlArray(): array
    {
        return ['dos:Other' => $this->others->map(static function (Other $other) {
                return [
                    'dos:ExternalRemark'  => $other->getExternalRemark(),
                    'dos:InternalRemark'  => $other->getInternalRemark(),
                    'dos:Layer'           => $other->getLayer(),
                    'dos:OtherIdentifier' => $other->getOtherIdentifier(),
                    'dos:Quantity'        => $other->getQuantity()
                ];
            })->toArray()
        ];
    }

    /**
     * @return Collection
     */
    public function toCollection(): Collection
    {
        return $this->others;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->others->isEmpty();
    }
}