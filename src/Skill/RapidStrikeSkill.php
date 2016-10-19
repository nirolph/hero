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
use Skill\Service\Chance\ChanceAwareInterface;
use Skill\Service\Chance\ChanceInterface;
use Strike\BasicStrike;
use Strike\StrikeCollection;

class RapidStrikeSkill implements OffenceSkillInterface,
    BroadcasterAwareInterface, ChanceAwareInterface
{
    const SKILL_NAME = 'RAPID STRIKE';
    const LUCK_FACTOR = 10;

    private $attacker;
    private $effectiveness = 0;
    private $isEffective = false;
    private $broadcaster;
    private $chance;

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
        if ($this->isEffective) {
            $strikeCollection = new StrikeCollection();
            $this->getBroadcaster()->broadcast(
                sprintf('%s uses %s. He strikes twice.', $this->attacker->getName(), self::SKILL_NAME)
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
        return $this->getChance()->amILucky(self::LUCK_FACTOR);
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

    public function setChance(ChanceInterface $chance)
    {
        $this->chance = $chance;
    }

    public function getChance()
    {
        return $this->chance;
    }

}