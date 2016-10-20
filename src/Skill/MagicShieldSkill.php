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

class MagicShieldSkill implements DefenceSkillInterface, BroadcasterAwareInterface, ChanceAwareInterface
{
    const SKILL_NAME = 'MAGIC SHIELD';
    const LUCK_FACTOR = 20;
    const NO_EFFECTIVENESS = -999;

    private $defender;
    private $effectiveness = self::NO_EFFECTIVENESS;
    private $isEffective = false;
    private $broadcaster;
    private $chance;

    public static function attachTo(EntityInterface $entity)
    {
        return new self($entity);
    }

    public function __construct(EntityInterface $entity)
    {
        $this->defender = $entity;
    }

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

    public function getDefenceEffectiveness(StrikeInterface $strike)
    {
        return $this->calculateHealthAfterStrike(
            $strike->getPower(),
            $this->defender->getStats()->getHealth(),
            $this->defender->getStats()->getDefence()
        );
    }

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

    private function isLucky()
    {
        return $this->getChance()->amILucky(self::LUCK_FACTOR);
    }

    private function reset()
    {
        $this->isEffective = false;
        $this->effectiveness = self::NO_EFFECTIVENESS;
    }

    public function setBroadcaster(BroadcasterInterface $broadcaster)
    {
        $this->broadcaster = $broadcaster;
    }

    public function getBroadcaster()
    {
        return $this->broadcaster;
    }

    public function setChance(ChanceInterface $chance)
    {
        $this->chance = $chance;
    }

    public function getChance()
    {
        return $this->chance;
    }

    private function calculateDamage($strikePower)
    {
        $damage = $strikePower - $this->defender->getStats()->getDefence();
        return (int)ceil($damage/2);
    }

}