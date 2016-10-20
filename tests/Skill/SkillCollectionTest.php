<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 20.10.2016
 * Time: 18:28
 */

namespace Test\Skill;


use PHPUnit\Framework\TestCase;
use Skill\AttackSkill;
use Skill\DefenceSkillInterface;
use Skill\DefendSkill;
use Skill\OffenceSkillInterface;
use Skill\SkillCollection;

class SkillCollectionTest extends TestCase
{
    public function testHandleAddingSkills()
    {
        $entity = $this->getMockBuilder(\Player\Entity\Beast::class)->getMock();

        $attackSkill1 = $this->getMockBuilder(AttackSkill::class)
            ->setConstructorArgs([$entity])->getMock();
        $attackSkill2 = $this->getMockBuilder(AttackSkill::class)
            ->setConstructorArgs([$entity])->getMock();;

        $defenceSkill1 = $this->getMockBuilder(DefendSkill::class)
            ->setConstructorArgs([$entity])->getMock();;
        $defenceSkill2 = $this->getMockBuilder(DefendSkill::class)
            ->setConstructorArgs([$entity])->getMock();;
        $defenceSkill3 = $this->getMockBuilder(DefendSkill::class)
            ->setConstructorArgs([$entity])->getMock();;

        $skillCollection = new SkillCollection();
        $skillCollection->add($attackSkill1);
        $skillCollection->add($attackSkill2);
        $skillCollection->add($defenceSkill1);
        $skillCollection->add($defenceSkill2);
        $skillCollection->add($defenceSkill3);

        $this->validateAttackSkillCollection($skillCollection);
        $this->validateDefenceSkillCollection($skillCollection);
    }

    private function validateAttackSkillCollection($skillCollection)
    {
        $skillCollection->setCurrentSkillSet(SkillCollection::OFFENSE_SKILL_SET);
        $offenceSkillCount = 0;
        foreach ($skillCollection as $skill) {
            $this->assertTrue($skill instanceOf OffenceSkillInterface);
            ++$offenceSkillCount;
        }
        $this->assertEquals(2, $offenceSkillCount);
    }

    private function validateDefenceSkillCollection($skillCollection)
    {
        $skillCollection->setCurrentSkillSet(SkillCollection::DEFENCE_SKILL_SET);
        $defenceSkillCount = 0;
        foreach ($skillCollection as $skill) {
            $this->assertTrue($skill instanceOf DefenceSkillInterface);
            ++$defenceSkillCount;
        }
        $this->assertEquals(3, $defenceSkillCount);
    }
}