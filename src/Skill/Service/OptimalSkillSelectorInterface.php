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

interface OptimalSkillSelectorInterface
{
    public function determineOptimalOffenseSkill(SkillCollection $skills);
    public function determineOptimalDefenceSkill(SkillCollection $skills, StrikeInterface $strike);
}