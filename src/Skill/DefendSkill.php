<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 19:53
 */

namespace Skill;


use Match\Broadcaster\BroadcasterAwareInterface;
use Match\Broadcaster\BroadcasterInterface;
use Strike\StrikeInterface;
use Player\EntityInterface;

class DefendSkill implements DefenceSkillInterface, BroadcasterAwareInterface
{
    private $defender;
    private $broadcaster;
    private $isEffective = false;

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
        $newHealth = $this->calculateHealthAfterStrike(
            $strike->getPower(),
            $this->defender->getStats()->getHealth(),
            $this->defender->getStats()->getDefence()
        );
        $this->defender->getStats()->setHealth($newHealth);
    }

    public function getDefenceEffectiveness(StrikeInterface $strike)
    {
        $this->isEffective = true;
        return $this->calculateHealthAfterStrike(
            $strike->getPower(),
            $this->defender->getStats()->getHealth(),
            $this->defender->getStats()->getDefence()
        );
    }

    private function calculateHealthAfterStrike($strikePower, $healthPoints, $defencePoints)
    {
        $damage = $strikePower - $defencePoints;
        if ($this->isEffective) {
            $this->getBroadcaster()->broadcast(
                sprintf('%s takes %s HP in damage!', $this->defender->getName(), $damage)
            );
            $this->isEffective = false;
        }
        $newHealth = $healthPoints-$damage;
        return $newHealth;
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