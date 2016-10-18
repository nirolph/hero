<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 22:31
 */

namespace Player\Entity;

use Match\Broadcaster\BroadcasterAwareInterface;
use Match\Broadcaster\BroadcasterInterface;
use Player\EntityInterface;
use Player\Stats\StatsInterface;
use Skill\Service\Chance\ChanceInterface;
use Skill\Service\OptimalSkillSelectorInterface;
use Skill\SkillCollection;
use Strike\StrikeCollection;
use Strike\StrikeInterface;

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
        $this->getBroadcaster()->broadcast(sprintf('%s attacks!', $this->getName()));
        $optimalSkill = $this->getOptimalSkillSelector()
            ->determineOptimalOffenseSkill($this->getOffenceSkills());
        return $optimalSkill->attack();
    }

    public function defend(StrikeCollection $strikes)
    {
        $this->getBroadcaster()->broadcast(sprintf('%s tries to defend!', $this->getName()));
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


}