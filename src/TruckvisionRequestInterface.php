<?php

namespace Xolvio\TruckvisionApi;

interface TruckvisionRequestInterface
{
    /**
     * @return string
     */
    public function build(\SoapClient $client): string;
}