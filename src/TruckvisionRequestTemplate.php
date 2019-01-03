<?php

namespace Xolvio\TruckvisionApi;

class TruckvisionRequestTemplate
{
    /**
     * @var TruckvisionRequestInterface
     */
    private $request;

    public function __construct(TruckvisionRequestInterface $request)
    {
        $this->request  = $request;
        $this->template = $this->setUpTemplate();
    }

    private function setUpTemplate(): string
    {
        
    }
}
