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
use Strike\StrikeInterface;
use Player\EntityInterface;

class MagicShieldSkill implements DefenceSkillInterface, BroadcasterAwareInterface
{
    private $defender;
    private $effectiveness = 0;
    private $isEffective = false;
    private $broadcaster;

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
            $this->getBroadcaster()->broadcast(sprintf(
                '%s uses Magic Shield. Takes only %s HP in damage.',
                $this->defender->getName(), ($strike->getPower() / 2)
            ));
            $newHealth = $this->calculateHealthAfterStrike(
                $strike->getPower(),
                $this->defender->getStats()->getHealth(),
                $this->defender->getStats()->getDefence()
            );

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

    private function calculateHealthAfterStrike($strikePower, $healthPoints, $defencePoints)
    {
        if ($this->isLucky()) {
            $damage = $strikePower - $defencePoints;
            $damage = (int)ceil($damage/2);
            $newHealth = $healthPoints-$damage;
            $this->effectiveness = $newHealth;
            $this->isEffective = true;
            return $newHealth;
        }
        return $this->effectiveness;
    }

    private function isLucky()
    {
        return (mt_rand(1,100) <= 20);
    }

    private function reset()
    {
        $this->isEffective = false;
        $this->effectiveness = 0;
    }

    public function setBroadcaster(BroadcasterInterface $broadcaster)
    {
        $this->broadcaster = $broadcaster;
    }

    public function getBroadcaster()
    {
        return $this->broadcaster;
    }

}