<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 22:01
 */

namespace Skill\Service\Chance;


use Player\EntityInterface;

interface ChanceInterface
{
    public function amILucky($chance);
}