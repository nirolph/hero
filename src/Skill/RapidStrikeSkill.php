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
use Player\EntityInterface;
use Strike\BasicStrike;
use Strike\StrikeCollection;

class RapidStrikeSkill implements OffenceSkillInterface, BroadcasterAwareInterface
{
    private $attacker;
    private $effectiveness = 0;
    private $isEffective = false;
    private $broadcaster;

    public static function attachTo(EntityInterface $entity)
    {
        return new self($entity);
    }

    public function __construct(EntityInterface $entity)
    {
        $this->attacker = $entity;
    }

    public function attack()
    {
        $strikeCollection = new StrikeCollection();
        if ($this->isEffective) {
            $this->getBroadcaster()->broadcast(
                sprintf('%s uses Rapid Strike. He strikes twice.', $this->attacker->getName())
            );
            $power = $this->attacker->getStats()->getStrength();
            $strike = BasicStrike::create($power);
            $secondStrike = BasicStrike::create($power);
            $strikeCollection->add($strike);
            $strikeCollection->add($secondStrike);
            $this->reset();
            return $strikeCollection;
        }
    }

    public function getOffenseEffectiveness()
    {
        if ($this->isLucky()) {
            $this->isEffective = true;
            $this->effectiveness = ($this->attacker->getStats()->getStrength() * 2);
        }
        return $this->effectiveness;
    }

    private function isLucky()
    {
        return (mt_rand(1,100) <= 10);
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