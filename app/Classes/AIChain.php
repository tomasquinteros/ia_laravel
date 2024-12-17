<?php

namespace App\Classes;

class AIChain
{
    private array $ias;

    public function __construct(array $ias)
    {
        $this->ias = $ias;
    }


    public function getIas(): array
    {
        return $this->ias;
    }


}