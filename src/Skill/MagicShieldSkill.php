<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 19:36
 */

namespace Skill;


use Match\Broadcaster\BroadcasterAwareInterface;
use Match\Broadcaster\BroadcasterInterface;
use Skill\Service\Chance\ChanceAwareInterface;
use Skill\Service\Chance\ChanceInterface;
use Strike\StrikeInterface;
use Player\EntityInterface;

/**
 * This defensive skill halves the damage taken
 * There's a 20% chance the player will use it
 * Class MagicShieldSkill
 * @package Skill
 */
class MagicShieldSkill implements DefenceSkillInterface, BroadcasterAwareInterface, ChanceAwareInterface
{
    /**
     * Skill name
     */
    const SKILL_NAME = 'MAGIC SHIELD';

    /**
     * The chance of it working
     */
    const LUCK_FACTOR = 20;

    /**
     * Value returned if not effective
     */
    const NO_EFFECTIVENESS = -999;

    /**
     * @var EntityInterface
     */
    private $defender;

    /**
     * @var int
     */
    private $effectiveness = self::NO_EFFECTIVENESS;

    /**
     * @var bool
     */
    private $isEffective = false;

    /**
     * @var BroadcasterInterface
     */
    private $broadcaster;

    /**
     * @var ChanceInterface
     */
    private $chance;

    /**
     * MagicShieldSkill constructor.
     * @param EntityInterface $entity
     */
    public function __construct(EntityInterface $entity)
    {
        $this->defender = $entity;
    }

    /**
     * @param EntityInterface $entity
     * @return MagicShieldSkill
     */
    public static function attachTo(EntityInterface $entity)
    {
        return new self($entity);
    }

    /**
     * @param StrikeInterface $strike
     */
    public function defend(StrikeInterface $strike)
    {
        if ($this->isEffective) {
            $newHealth = $this->calculateHealthAfterStrike(
                $strike->getPower(),
                $this->defender->getStats()->getHealth(),
                $this->defender->getStats()->getDefence()
            );

            $damage = $this->calculateDamage($strike->getPower());
            $this->getBroadcaster()->broadcast(sprintf(
                '%s uses %s. Takes only %s HP in damage.',
                $this->defender->getName(),
                self::SKILL_NAME,
                $damage
            ));

            $this->defender->getStats()->setHealth($newHealth);
            $this->reset();
        }
    }

    /**
     * @param StrikeInterface $strike
     * @return int
     */
    public function getDefenceEffectiveness(StrikeInterface $strike)
    {
        return $this->calculateHealthAfterStrike(
            $strike->getPower(),
            $this->defender->getStats()->getHealth(),
            $this->defender->getStats()->getDefence()
        );
    }

    /**
     * @param $strikePower
     * @param $healthPoints
     * @return int
     */
    private function calculateHealthAfterStrike($strikePower, $healthPoints)
    {
        if ($this->isLucky()) {
            $damage = $this->calculateDamage($strikePower);
            $newHealth = $healthPoints-$damage;
            $this->effectiveness = $newHealth;
            $this->isEffective = true;
            return $newHealth;
        }
        return $this->effectiveness;
    }

    /**
     * @return bool
     */
    private function isLucky()
    {
        return $this->getChance()->amILucky(self::LUCK_FACTOR);
    }

    /**
     * Reset effectiveness
     * Called after each use
     */
    private function reset()
    {
        $this->isEffective = false;
        $this->effectiveness = self::NO_EFFECTIVENESS;
    }

    /**
     * @param BroadcasterInterface $broadcaster
     */
    public function setBroadcaster(BroadcasterInterface $broadcaster)
    {
        $this->broadcaster = $broadcaster;
    }

    /**
     * @return BroadcasterInterface
     */
    public function getBroadcaster()
    {
        return $this->broadcaster;
    }

    /**
     * @param ChanceInterface $chance
     */
    public function setChance(ChanceInterface $chance)
    {
        $this->chance = $chance;
    }

    /**
     * @return ChanceInterface
     */
    public function getChance()
    {
        return $this->chance;
    }

    /**
     * @param $strikePower
     * @return int
     */
    private function calculateDamage($strikePower)
    {
        $damage = $strikePower - $this->defender->getStats()->getDefence();
        return (int)ceil($damage/2);
    }

}