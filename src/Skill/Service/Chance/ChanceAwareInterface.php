<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 22:05
 */

namespace Skill\Service\Chance;


interface ChanceAwareInterface
{
    public function setChance(ChanceInterface $chance);
    public function getChance();
}