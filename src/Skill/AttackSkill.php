<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 19:47
 */

namespace Skill;


use Match\Broadcaster\BroadcasterAwareInterface;
use Match\Broadcaster\BroadcasterInterface;
use Player\EntityInterface;
use Strike\BasicStrike;
use Strike\StrikeCollection;

class AttackSkill implements OffenceSkillInterface, BroadcasterAwareInterface
{
    private $attacker;
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
        $power = $this->attacker->getStats()->getStrength();
        $this->getBroadcaster()->broadcast(
            sprintf('%s strikes with %s power', $this->attacker->getName(), $power)
        );
        $strike = BasicStrike::create($power);
        $strikeCollection->add($strike);
        return $strikeCollection;
    }

    public function getOffenseEffectiveness()
    {
        return $this->attacker->getStats()->getStrength();
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