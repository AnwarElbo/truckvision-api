<?php

namespace Xolvio\TruckvisionApi;

interface TruckvisionRequestInterface
{
    /**
     * @return string
     */
    public function build(): string;
}
