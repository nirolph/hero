<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 22:05
 */

namespace Skill\Service\Chance;

/**
 * Interface ChanceAwareInterface
 * @package Skill\Service\Chance
 */
interface ChanceAwareInterface
{
    /**
     * @param ChanceInterface $chance
     */
    public function setChance(ChanceInterface $chance);

    /**
     * @return ChanceInterface
     */
    public function getChance();
}