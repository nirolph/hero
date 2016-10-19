<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 22:31
 */

namespace Player\Entity;

use Skill\SkillCollection;
use Strike\StrikeInterface;
use Player\EntityInterface;
use Strike\StrikeCollection;
use Player\Stats\StatsInterface;
use Skill\Service\Chance\ChanceInterface;
use Match\Broadcaster\BroadcasterInterface;
use Match\Broadcaster\BroadcasterAwareInterface;
use Skill\Service\OptimalSkillSelectorInterface;

abstract class BasicEntity implements EntityInterface, BroadcasterAwareInterface
{
    private $stats;
    private $skillCollection;
    private $skillSelector;
    private $chance;
    private $broadcaster;

    public function attack()
    {
        if (empty($this->getOffenceSkills())) {
            throw new \Exception('No attack skills found!');
        }
        $optimalSkill = $this->getOptimalSkillSelector()
            ->determineOptimalOffenseSkill($this->getOffenceSkills());
        return $optimalSkill->attack();
    }

    public function defend(StrikeCollection $strikes)
    {
        foreach ($strikes as $strike) {
            $this->handleStrike($strike);
        }
    }

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

    public function lucky()
    {
        return $this->chance->amILucky($this->stats->getLuck());
    }

    public function setSkills(SkillCollection $skillCollection)
    {
        $this->skillCollection = $skillCollection;
    }

    public function getSkills()
    {
        return $this->skillCollection;
    }

    private function getDefenceSkills()
    {
        return $this->skillCollection->setCurrentSkillSet(SkillCollection::DEFENCE_SKILL_SET);
    }

    private function getOffenceSkills()
    {
        return $this->skillCollection->setCurrentSkillSet(SkillCollection::OFFENSE_SKILL_SET);
    }

    public function getStats()
    {
        return $this->stats;
    }

    public function setStats(StatsInterface $stats)
    {
        $this->stats = $stats;
    }

    public function getOptimalSkillSelector()
    {
        return $this->skillSelector;
    }

    public function setOptimalSkillSelector(OptimalSkillSelectorInterface $selector)
    {
        $this->skillSelector = $selector;
    }

    public function setChance(ChanceInterface $chance)
    {
        $this->chance = $chance;
    }

    public function getChance()
    {
        return $this->chance;
    }

    public function setBroadcaster(BroadcasterInterface $broadcaster)
    {
        $this->broadcaster = $broadcaster;
    }

    public function getBroadcaster()
    {
        return $this->broadcaster;
    }

    public function isDead()
    {
        return ($this->getStats()->getHealth() <= 0);
    }
}