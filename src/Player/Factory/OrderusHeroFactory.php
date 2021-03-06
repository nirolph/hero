<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 18:29
 */

namespace Player\Factory;


use Match\Broadcaster\MessageBroadcaster;
use Player\Entity\Hero;
use Player\Stats\PlayerStats;
use Skill\AttackSkill;
use Skill\DefendSkill;
use Skill\MagicShieldSkill;
use Skill\RapidStrikeSkill;
use Skill\Service\Chance\LuckyService;
use Skill\Service\OptimalSkillSelectorService;
use Skill\SkillCollection;
use Match\Broadcaster\BroadcasterInterface;

/**
 * Hero factory
 * Class OrderusHeroFactory
 * @package Player\Factory
 */
class OrderusHeroFactory implements FactoryInterface
{
    /**
     * Health range
     */
    const HEALTH_MIN      = 70;
    const HEALTH_MAX      = 100;

    /**
     * Strength range
     */
    const STRENGTH_MIN    = 70;
    const STRENGTH_MAX    = 80;

    /**
     * Defence range
     */
    const DEFENCE_MIN     = 45;
    const DEFENCE_MAX     = 55;

    /**
     * Speed range
     */
    const SPEED_MIN       = 40;
    const SPEED_MAX       = 50;

    /**
     * Luck range
     */
    const LUCK_MIN        = 10;
    const LUCK_MAX        = 30;

    /**
     * Message broadcaster
     * @var BroadcasterInterface
     */
    private $broadcaster;

    /**
     * Spawn the hero called Orderus
     * @return Hero
     */
    public function create()
    {
        $stats = $this->getPlayerStats();
        $orderus = new Hero();
        $orderus->setName('Orderus');
        $orderus->setStats($stats);
        $orderus->setOptimalSkillSelector(new OptimalSkillSelectorService());
        $orderus->setChance(new LuckyService());
        $skills = $this->getSkills($orderus);
        $orderus->setSkills($skills);
        $orderus->setBroadcaster($this->broadcaster);
        return $orderus;

    }

    /**
     * Get hero's stats
     * @return PlayerStats
     */
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

    /**
     * Get hero's skills
     * @param Hero $orderus
     * @return SkillCollection
     * @throws \Exception
     */
    private function getSkills(Hero $orderus)
    {
        $skillCollection = new SkillCollection();

        $attackSkill = AttackSkill::attachTo($orderus);
        $defendSkill = DefendSkill::attachTo($orderus);
        $rapidStrikeSkill = RapidStrikeSkill::attachTo($orderus);
        $magicShieldSkill = MagicShieldSkill::attachTo($orderus);

        $attackSkill->setBroadcaster($this->broadcaster);
        $defendSkill->setBroadcaster($this->broadcaster);
        $rapidStrikeSkill->setBroadcaster($this->broadcaster);
        $rapidStrikeSkill->setChance(new LuckyService());
        $magicShieldSkill->setBroadcaster($this->broadcaster);
        $magicShieldSkill->setChance(new LuckyService());

        $skillCollection->add($attackSkill);
        $skillCollection->add($defendSkill);
        $skillCollection->add($rapidStrikeSkill);
        $skillCollection->add($magicShieldSkill);
        return $skillCollection;
    }

    /**
     * Get message broadcaster
     * @param BroadcasterInterface $broadcaster
     */
    public function addBroadcaster(BroadcasterInterface $broadcaster)
    {
        $this->broadcaster = $broadcaster;
    }

}