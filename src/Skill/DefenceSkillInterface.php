<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 19:38
 */

namespace Skill;

use Strike\StrikeInterface;

/**
 * Interface DefenceSkillInterface
 * @package Skill
 */
interface DefenceSkillInterface extends SkillInterface
{
    /**
     * @param StrikeInterface $strike
     * @return mixed
     */
    public function defend(StrikeInterface $strike);

    /**
     * @param StrikeInterface $strike
     * @return mixed
     */
    public function getDefenceEffectiveness(StrikeInterface $strike);
}