<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 18:29
 */

namespace Player\Factory;


use Match\Broadcaster\MessageBroadcaster;
use Player\Entity\Beast;
use Player\Stats\PlayerStats;
use Skill\AttackSkill;
use Skill\DefendSkill;
use Skill\Service\Chance\LuckyService;
use Skill\Service\OptimalSkillSelectorService;
use Skill\SkillCollection;

class BeastFactory implements FactoryInterface
{
    /**
     * Health range
     */
    const HEALTH_MIN      = 60;
    const HEALTH_MAX      = 90;

    /**
     * Strength range
     */
    const STRENGTH_MIN    = 60;
    const STRENGTH_MAX    = 90;

    /**
     * Defence range
     */
    const DEFENCE_MIN     = 40;
    const DEFENCE_MAX     = 60;

    /**
     * Speed range
     */
    const SPEED_MIN       = 40;
    const SPEED_MAX       = 60;

    /**
     * Luck range
     */
    const LUCK_MIN        = 25;
    const LUCK_MAX        = 40;

    public function create()
    {
        $stats = $this->getPlayerStats();
        $beast = new Beast();
        $beast->setBroadcaster(new MessageBroadcaster());
        $beast->setName('Hellfire');
        $beast->setStats($stats);
        $beast->setOptimalSkillSelector(new OptimalSkillSelectorService());
        $beast->setChance(new LuckyService());
        $skills = $this->getSkills($beast);
        $beast->setSkills($skills);
        return $beast;

    }

    private function getPlayerStats()
    {
        $stats = new PlayerStats();
        $stats->setHealth(mt_rand(self::HEALTH_MIN, self::HEALTH_MAX));
        $stats->setStrength(mt_rand(self::STRENGTH_MIN, self::STRENGTH_MAX));
        $stats->setDefence(mt_rand(self::DEFENCE_MIN, self::DEFENCE_MAX));
        $stats->setSpeed(mt_rand(self::SPEED_MIN, self::SPEED_MAX));
        $stats->setLuck(mt_rand(self::LUCK_MIN, self::LUCK_MAX));
        return $stats;
    }

    private function getSkills(Beast $beast)
    {
        $skillCollection = new SkillCollection();
        $attackSkill = AttackSkill::attachTo($beast);
        $defendSkill = DefendSkill::attachTo($beast);
        $attackSkill->setBroadcaster(new MessageBroadcaster());
        $defendSkill->setBroadcaster(new MessageBroadcaster());
        $skillCollection->add($attackSkill);
        $skillCollection->add($defendSkill);
        return $skillCollection;
    }

}