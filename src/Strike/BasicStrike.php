<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 21:08
 */

namespace Strike;

/**
 * Class BasicStrike
 * @package Strike
 */
class BasicStrike implements StrikeInterface
{
    /**
     * Power of a strike
     * @var int
     */
    private $power;

    /**
     * @param $power
     * @return BasicStrike
     */
    public static function create($power)
    {
        $strike = new self();
        $strike->setPower($power);
        return $strike;
    }

    /**
     * @return int
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * @param int $power
     */
    public function setPower($power)
    {
        $this->power = $power;
    }

}