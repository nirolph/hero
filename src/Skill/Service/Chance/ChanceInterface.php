<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 22:01
 */

namespace Skill\Service\Chance;

/**
 * Interface ChanceInterface
 * @package Skill\Service\Chance
 */
interface ChanceInterface
{
    /**
     * @param $chance
     * @return bool
     */
    public function amILucky($chance);
}