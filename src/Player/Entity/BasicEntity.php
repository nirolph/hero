<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 22:31
 */

namespace Player\Entity;

use Player\Stats\PlayerStats;
use Skill\SkillCollection;
use Strike\StrikeInterface;
use Player\EntityInterface;
use Strike\StrikeCollection;
use Player\Stats\StatsInterface;
use Skill\Service\Chance\ChanceInterface;
use Match\Broadcaster\BroadcasterInterface;
use Match\Broadcaster\BroadcasterAwareInterface;
use Skill\Service\OptimalSkillSelectorInterface;

/**
 * Basic player entity
 * Class BasicEntity
 * @package Player\Entity
 */
abstract class BasicEntity implements EntityInterface, BroadcasterAwareInterface
{
    /**
     * The player stats
     * @var PlayerStats
     */
    private $stats;

    /**
     * The player's skills
     * @var SkillCollection
     */
    private $skillCollection;

    /**
     * Object that selects the optimal skill to use (defence or offence)
     * @var OptimalSkillSelectorInterface
     */
    private $skillSelector;

    /**
     * Is destiny on your side? :P
     * @var ChanceInterface
     */
    private $chance;

    /**
     * The message broadcaster
     * @var BroadcasterInterface
     */
    private $broadcaster;

    /**
     * Attack
     * @return mixed
     * @throws \Exception
     */
    public function attack()
    {
        if (empty($this->getOffenceSkills())) {
            throw new \Exception('No attack skills found!');
        }
        $optimalSkill = $this->getOptimalSkillSelector()
            ->determineOptimalOffenseSkill($this->getOffenceSkills());
        return $optimalSkill->attack();
    }

    /**
     * Defend from strikes
     * @param StrikeCollection $strikes
     */
    public function defend(StrikeCollection $strikes)
    {
        foreach ($strikes as $strike) {
            $this->handleStrike($strike);
        }
    }

    /**
     * Handle the opponent strike
     * @param StrikeInterface $strike
     */
    private function handleStrike(StrikeInterface $strike)
    {
        if ($this->lucky()) {
            $this->getBroadcaster()->broadcast(
                sprintf('%s got lucky. The strike missed.', $this->getName())
            );

            return;
        }

        $optimalSkill = $this->getOptimalSkillSelector()
            ->determineOptimalDefenceSkill($this->getDefenceSkills(), $strike);
        $optimalSkill->defend($strike);
    }

    /**
     * Am I lucky
     * @return bool
     */
    public function lucky()
    {
        return $this->chance->amILucky($this->stats->getLuck());
    }

    /**
     * Set player skills
     * @param SkillCollection $skillCollection
     */
    public function setSkills(SkillCollection $skillCollection)
    {
        $this->skillCollection = $skillCollection;
    }

    /**
     * Get player skills
     * @return SkillCollection
     */
    public function getSkills()
    {
        return $this->skillCollection;
    }

    /**
     * Get defence skills
     * @return $this
     * @throws \Exception
     */
    private function getDefenceSkills()
    {
        return $this->skillCollection->setCurrentSkillSet(SkillCollection::DEFENCE_SKILL_SET);
    }

    /**
     * Get offence skills
     * @return $this
     * @throws \Exception
     */
    private function getOffenceSkills()
    {
        return $this->skillCollection->setCurrentSkillSet(SkillCollection::OFFENSE_SKILL_SET);
    }

    /**
     * Get player stats
     * @return PlayerStats
     */
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * Set player stats
     * @param StatsInterface $stats
     */
    public function setStats(StatsInterface $stats)
    {
        $this->stats = $stats;
    }

    /**
     * Get optimal skill selector
     * @return OptimalSkillSelectorInterface
     */
    public function getOptimalSkillSelector()
    {
        return $this->skillSelector;
    }

    /**
     * set optimal skill selector
     * @param OptimalSkillSelectorInterface $selector
     */
    public function setOptimalSkillSelector(OptimalSkillSelectorInterface $selector)
    {
        $this->skillSelector = $selector;
    }

    /**
     * Set chance
     * @param ChanceInterface $chance
     */
    public function setChance(ChanceInterface $chance)
    {
        $this->chance = $chance;
    }

    /**
     * Get chance
     * @return ChanceInterface
     */
    public function getChance()
    {
        return $this->chance;
    }

    /**
     * Set message broadcaster
     * @param BroadcasterInterface $broadcaster
     */
    public function setBroadcaster(BroadcasterInterface $broadcaster)
    {
        $this->broadcaster = $broadcaster;
    }

    /**
     * Get message broadcaster
     * @return BroadcasterInterface
     */
    public function getBroadcaster()
    {
        return $this->broadcaster;
    }

    /**
     * Is the player dead?
     * @return bool
     */
    public function isDead()
    {
        return ($this->getStats()->getHealth() <= 0);
    }
}