<?php
namespace App\Processor\Validation;

/**
 *
 */
class ExpirePeriod
{
    //expire period after issue date
    private $expirePeriod;

    public function __construct($expirePeriod)
    {
        $this->expirePeriod = $expirePeriod;
    }

    public function setExpirePeriod($expirePeriod)
    {
        $this->expirePeriod = $expirePeriod;
    }

    public function getExpirePeriod()
    {
        return $this->expirePeriod;
    }
}
