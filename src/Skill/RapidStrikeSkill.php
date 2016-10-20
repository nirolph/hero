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

/**
 * This enables player to strike twice in rapid successions
 * There's a 10% chance the player will use it
 * Class RapidStrikeSkill
 * @package Skill
 */
class RapidStrikeSkill implements OffenceSkillInterface,
    BroadcasterAwareInterface, ChanceAwareInterface
{
    /**
     * Skill name
     */
    const SKILL_NAME = 'RAPID STRIKE';

    /**
     * The chance the player will use it
     */
    const LUCK_FACTOR = 10;

    /**
     * @var EntityInterface
     */
    private $attacker;

    /**
     * Attack effectiveness
     * @var int
     */
    private $effectiveness = 0;

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
     * RapidStrikeSkill constructor.
     * @param EntityInterface $entity
     */
    public function __construct(EntityInterface $entity)
    {
        $this->attacker = $entity;
    }

    /**
     * @param EntityInterface $entity
     * @return RapidStrikeSkill
     */
    public static function attachTo(EntityInterface $entity)
    {
        return new self($entity);
    }

    /**
     * @return StrikeCollection
     */
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

    /**
     * @return int
     */
    public function getOffenseEffectiveness()
    {
        if ($this->isLucky()) {
            $this->isEffective = true;
            $this->effectiveness = ($this->attacker->getStats()->getStrength() * 2);
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
     */
    private function reset()
    {
        $this->isEffective = false;
        $this->effectiveness = 0;
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

}