<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 19:35
 */

namespace Skill;


interface OffenceSkillInterface extends SkillInterface
{
    public function attack();
    public function getOffenseEffectiveness();
}