<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 21:40
 */

namespace Skill\Service;


use Skill\DefenceSkillInterface;
use Skill\OffenceSkillInterface;
use Skill\SkillCollection;
use Strike\StrikeInterface;

/**
 * Class OptimalSkillSelectorService
 * @package Skill\Service
 */
class OptimalSkillSelectorService implements OptimalSkillSelectorInterface
{
    /**
     * @param SkillCollection $skills
     * @return OffenceSkillInterface
     */
    public function determineOptimalOffenseSkill(SkillCollection $skills)
    {
        $attackRank = [];
        foreach ($skills as $skill) {
            $rank = $skill->getOffenseEffectiveness();
            $attackRank[$rank] = $skill;
        }
        krsort($attackRank);
        return reset($attackRank);
    }

    /**
     * @param SkillCollection $skills
     * @param StrikeInterface $strike
     * @return DefenceSkillInterface
     */
    public function determineOptimalDefenceSkill(SkillCollection $skills, StrikeInterface $strike)
    {
        $defendRank = [];
        foreach ($skills as $skill) {
            $rank = $skill->getDefenceEffectiveness($strike);
            $defendRank[$rank] = $skill;
        }

        krsort($defendRank);
        return reset($defendRank);
    }

}