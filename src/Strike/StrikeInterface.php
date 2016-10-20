<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 18:56
 */

namespace Strike;

/**
 * Interface StrikeInterface
 * @package Strike
 */
interface StrikeInterface
{
    /**
     * @return int
     */
    public function getPower();

    /**
     * @param int $power
     */
    public function setPower($power);
}