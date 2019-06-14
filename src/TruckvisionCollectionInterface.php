<?php


namespace Xolvio\TruckvisionApi;


use Illuminate\Support\Collection;

interface TruckvisionCollectionInterface
{
    /**
     * @return array
     */
    public function toXmlArray(): array;

    /**
     * @return Collection
     */
    public function toCollection(): Collection;

    /**
     * @return bool
     */
    public function isEmpty(): bool;
}