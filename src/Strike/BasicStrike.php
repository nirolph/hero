<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 21:08
 */

namespace Strike;


class BasicStrike implements StrikeInterface
{
    private $power;

    public static function create($power)
    {
        $strike = new self();
        $strike->setPower($power);
        return $strike;
    }

    public function getPower()
    {
        return $this->power;
    }

    public function setPower($power)
    {
        $this->power = $power;
    }

}