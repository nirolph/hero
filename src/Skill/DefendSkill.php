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

/**
 * Class DefendSkill
 * @package Skill
 */
class DefendSkill implements DefenceSkillInterface, BroadcasterAwareInterface
{
    /**
     * Skill name
     */
    const SKILL_NAME = 'DEFEND';

    /**
     * @var EntityInterface
     */
    private $defender;

    /**
     * @var BroadcasterInterface
     */
    private $broadcaster;

    /**
     * @var bool
     */
    private $isEffective = false;

    /**
     * DefendSkill constructor.
     * @param EntityInterface $entity
     */
    public function __construct(EntityInterface $entity)
    {
        $this->defender = $entity;
    }

    /**
     * @param EntityInterface $entity
     * @return DefendSkill
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
        $newHealth = $this->calculateHealthAfterStrike(
            $strike->getPower(),
            $this->defender->getStats()->getHealth(),
            $this->defender->getStats()->getDefence()
        );

        $damage = $strike->getPower() - $this->defender->getStats()->getDefence();
        $this->getBroadcaster()->broadcast(
            sprintf(
                '%s uses %s and takes %s HP in damage!',
                $this->defender->getName(),
                self::SKILL_NAME, $damage
            )
        );

        $this->defender->getStats()->setHealth($newHealth);
    }

    /**
     * @param StrikeInterface $strike
     * @return int
     */
    public function getDefenceEffectiveness(StrikeInterface $strike)
    {
        $this->isEffective = true;
        return $this->calculateHealthAfterStrike(
            $strike->getPower(),
            $this->defender->getStats()->getHealth(),
            $this->defender->getStats()->getDefence()
        );
    }

    /**
     * @param $strikePower
     * @param $healthPoints
     * @param $defencePoints
     * @return int
     */
    private function calculateHealthAfterStrike($strikePower, $healthPoints, $defencePoints)
    {
        $damage = $strikePower - $defencePoints;
        $newHealth = $healthPoints-$damage;
        return $newHealth;
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