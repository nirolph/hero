<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 22:01
 */

namespace Skill\Service\Chance;


class LuckyService implements ChanceInterface
{
    public function amILucky($chance)
    {
        return (mt_rand(1,100) <= $chance);
    }
}