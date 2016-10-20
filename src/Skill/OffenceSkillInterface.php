<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 19:35
 */

namespace Skill;
use Strike\StrikeCollection;

/**
 * Interface OffenceSkillInterface
 * @package Skill
 */
interface OffenceSkillInterface extends SkillInterface
{
    /**
     * @return StrikeCollection
     */
    public function attack();

    /**
     * @return int
     */
    public function getOffenseEffectiveness();
}