<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 21:38
 */

namespace Skill\Service;


use Skill\SkillCollection;
use Strike\StrikeInterface;

/**
 * Interface OptimalSkillSelectorInterface
 * @package Skill\Service
 */
interface OptimalSkillSelectorInterface
{
    /**
     * @param SkillCollection $skills
     */
    public function determineOptimalOffenseSkill(SkillCollection $skills);

    /**
     * @param SkillCollection $skills
     * @param StrikeInterface $strike
     */
    public function determineOptimalDefenceSkill(SkillCollection $skills, StrikeInterface $strike);
}