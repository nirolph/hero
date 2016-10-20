<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 20.10.2016
 * Time: 17:17
 */

namespace Test\Skill\Service;


use PHPUnit\Framework\TestCase;
use Skill\AttackSkill;
use Skill\DefendSkill;
use Skill\Service\OptimalSkillSelectorService;
use Skill\SkillCollection;
use Player\Entity\BasicEntity;
use Strike\BasicStrike;

class OptimalSkillSelectorServiceTest extends TestCase
{
    public function testDetermineOptimalOffenseSkill()
    {
        $entity = $this->getMockBuilder(BasicEntity::class)->getMock();
        $skillCollection = new SkillCollection();
        $powerfulAttack = $this->getMockBuilder(AttackSkill::class)
            ->setConstructorArgs([$entity])
            ->setMethods(['getOffenseEffectiveness'])->getMock();
        $powerfulAttack->method('getOffenseEffectiveness')->willReturn(50);

        $weakAttack = $this->getMockBuilder(AttackSkill::class)
            ->setConstructorArgs([$entity])
            ->setMethods(['getOffenseEffectiveness'])->getMock();
        $weakAttack->method('getOffenseEffectiveness')->willReturn(10);

        $skillCollection->add($powerfulAttack);
        $skillCollection->add($weakAttack);
        $skillCollection->setCurrentSkillSet(SkillCollection::OFFENSE_SKILL_SET);

        $skillSelector = new OptimalSkillSelectorService();
        $optimalSkill = $skillSelector->determineOptimalOffenseSkill($skillCollection);
        $this->assertSame($powerfulAttack, $optimalSkill);
    }

    public function testDetermineOptimalDefenceSkill()
    {
        $entity = $this->getMockBuilder(BasicEntity::class)->getMock();
        $skillCollection = new SkillCollection();
        $powerfulDefence = $this->getMockBuilder(DefendSkill::class)
            ->setConstructorArgs([$entity])
            ->setMethods(['getDefenceEffectiveness'])->getMock();
        $powerfulDefence->method('getDefenceEffectiveness')->willReturn(50);

        $weakDefence = $this->getMockBuilder(DefendSkill::class)
            ->setConstructorArgs([$entity])
            ->setMethods(['getDefenceEffectiveness'])->getMock();
        $weakDefence->method('getDefenceEffectiveness')->willReturn(10);

        $skillCollection->add($powerfulDefence);
        $skillCollection->add($weakDefence);
        $skillCollection->setCurrentSkillSet(SkillCollection::DEFENCE_SKILL_SET);

        $strike = $this->getMockBuilder(BasicStrike::class)->getMock();

        $skillSelector = new OptimalSkillSelectorService();
        $optimalSkill = $skillSelector->determineOptimalDefenceSkill($skillCollection, $strike);
        $this->assertSame($powerfulDefence, $optimalSkill);
    }
}