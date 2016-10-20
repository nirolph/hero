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

/**
 * This skill helps deal
 * Class AttackSkill
 * @package Skill
 */
class AttackSkill implements OffenceSkillInterface, BroadcasterAwareInterface
{
    /**
     * Skill damage
     */
    const SKILL_NAME = 'ATTACK';

    /**
     * @var EntityInterface
     */
    private $attacker;

    /**
     * @var BroadcasterInterface
     */
    private $broadcaster;

    /**
     * AttackSkill constructor.
     * @param EntityInterface $entity
     */
    public function __construct(EntityInterface $entity)
    {
        $this->attacker = $entity;
    }

    /**
     * Attach skill to an EntityInterface
     * @param EntityInterface $entity
     * @return AttackSkill
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
        $strikeCollection = new StrikeCollection();
        $power = $this->getOffenseEffectiveness();
        $this->getBroadcaster()->broadcast(
            sprintf('%s uses %s', $this->attacker->getName(), self::SKILL_NAME)
        );
        $strike = BasicStrike::create($power);
        $strikeCollection->add($strike);
        return $strikeCollection;
    }

    /**
     * How effective will the skill be (higher is better)
     * @return int
     */
    public function getOffenseEffectiveness()
    {
        return $this->attacker->getStats()->getStrength();
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


}