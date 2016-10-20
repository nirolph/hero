<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 20.10.2016
 * Time: 12:24
 */

namespace Test\Player\Entity;


use PHPUnit\Framework\TestCase;
use Player\Stats\PlayerStats;
use Skill\Service\OptimalSkillSelectorService;
use Strike\BasicStrike;
use Strike\StrikeCollection;
use Skill\SkillCollection;
use Skill\DefendSkill;
use Skill\AttackSkill;
use Match\Broadcaster\MessageBroadcaster;

class BasicEntityTest extends TestCase
{
    private $entity;

    public function setUp()
    {
        $this->entity = $this->getMockBuilder(\Player\Entity\Beast::class)
            ->setMethods(['getName', 'lucky'])
            ->getMock();
        $this->entity->method('getName')->will($this->returnValue('test beast entity'));
    }

    /**
     * Assert isDead works
     */
    public function testIsDead()
    {
        $stats = $this->getMockBuilder(\Player\Stats\PlayerStats::class)
            ->setMethods(['getHealth'])
            ->getMock();
        $stats->method('getHealth')->will($this->returnValue(50));
        $this->entity->setStats($stats);

        $this->assertFalse($this->entity->isDead());
    }

    /**
     * Assert isDead works
     */
    public function testIsNotDead()
    {
        $stats = $this->getMockBuilder(\Player\Stats\PlayerStats::class)
            ->setMethods(['getHealth'])
            ->getMock();
        $stats->method('getHealth')->will($this->returnValue(0));
        $this->entity->setStats($stats);

        $this->assertTrue($this->entity->isDead());
    }

    /**
     * Assert an entity can attack
     * @throws \Exception
     */
    public function testCanAttack()
    {
        $optimalSkillSelector = new OptimalSkillSelectorService();
        $this->entity->setOptimalSkillSelector($optimalSkillSelector);

        $stats = new PlayerStats();
        $stats->setStrength(30);

        $skillCollection = new SkillCollection();
        $attackSkill = AttackSkill::attachTo($this->entity);
        $skillCollection->add($attackSkill);
        $this->entity->setSkills($skillCollection);

        $broadcaster = $this->getMockBuilder(MessageBroadcaster::class)
            ->setMethods(['broadcast'])->getMock();
        $broadcaster->method('broadcast')->willReturn('');
        $this->entity->setBroadcaster($broadcaster);
        $attackSkill->setBroadcaster($broadcaster);

        $this->entity->setStats($stats);
        $strikes = $this->entity->attack();
        $strike = reset(reset($strikes));
        $this->assertEquals(30, $strike->getPower());
    }

    /**
     * Assert entity can defend
     * @throws \Exception
     */
    public function testCanDefendWithoutLuck()
    {
        $strikeCollection = new StrikeCollection();
        $strike = $this->getMockBuilder(BasicStrike::class)->setMethods(['getPower'])->getMock();
        $strike->method('getPower')->will($this->returnValue(10));
        $strikeCollection->add($strike);

        $optimalSkillSelector = new OptimalSkillSelectorService();
        $this->entity->setOptimalSkillSelector($optimalSkillSelector);

        $stats = new PlayerStats();
        $stats->setHealth(50);
        $stats->setDefence(5);

        $skillCollection = new SkillCollection();
        $defendSkill = DefendSkill::attachTo($this->entity);
        $skillCollection->add($defendSkill);
        $this->entity->setSkills($skillCollection);

        $broadcaster = $this->getMockBuilder(MessageBroadcaster::class)
            ->setMethods(['broadcast'])->getMock();
        $broadcaster->method('broadcast')->willReturn('');
        $this->entity->setBroadcaster($broadcaster);
        $defendSkill->setBroadcaster($broadcaster);

        $this->entity->setStats($stats);
        $this->entity->method('lucky')->willReturn(false);

        $this->entity->defend($strikeCollection);
        $this->assertEquals(45, $this->entity->getStats()->getHealth());

    }

    /**
     * Assert that the entity can dodge attack when lucky
     * @throws \Exception
     */
    public function testCanDefendWithLuck()
    {
        $strikeCollection = new StrikeCollection();
        $strike = $this->getMockBuilder(BasicStrike::class)->setMethods(['getPower'])->getMock();
        $strike->method('getPower')->will($this->returnValue(10));
        $strikeCollection->add($strike);

        $optimalSkillSelector = new OptimalSkillSelectorService();
        $this->entity->setOptimalSkillSelector($optimalSkillSelector);

        $stats = new PlayerStats();
        $stats->setHealth(50);
        $stats->setDefence(5);

        $skillCollection = new SkillCollection();
        $defendSkill = DefendSkill::attachTo($this->entity);
        $skillCollection->add($defendSkill);
        $this->entity->setSkills($skillCollection);

        $broadcaster = $this->getMockBuilder(MessageBroadcaster::class)
            ->setMethods(['broadcast'])->getMock();
        $broadcaster->method('broadcast')->willReturn('');
        $this->entity->setBroadcaster($broadcaster);
        $defendSkill->setBroadcaster($broadcaster);

        $this->entity->setStats($stats);
        $this->entity->method('lucky')->willReturn(true);

        $this->entity->defend($strikeCollection);
        $this->assertEquals(50, $this->entity->getStats()->getHealth());

    }

    /**
     * Assert entity is not immortal
     * @throws \Exception
     */
    public function testCanDie()
    {
        $strikeCollection = new StrikeCollection();
        $strike = $this->getMockBuilder(BasicStrike::class)->setMethods(['getPower'])->getMock();
        $strike->method('getPower')->will($this->returnValue(100));
        $strikeCollection->add($strike);

        $optimalSkillSelector = new OptimalSkillSelectorService();
        $this->entity->setOptimalSkillSelector($optimalSkillSelector);

        $stats = new PlayerStats();
        $stats->setHealth(90);
        $stats->setDefence(5);

        $skillCollection = new SkillCollection();
        $defendSkill = DefendSkill::attachTo($this->entity);
        $skillCollection->add($defendSkill);
        $this->entity->setSkills($skillCollection);

        $broadcaster = $this->getMockBuilder(MessageBroadcaster::class)
            ->setMethods(['broadcast'])->getMock();
        $broadcaster->method('broadcast')->willReturn('');
        $this->entity->setBroadcaster($broadcaster);
        $defendSkill->setBroadcaster($broadcaster);

        $this->entity->setStats($stats);
        $this->entity->method('lucky')->willReturn(false);

        $this->entity->defend($strikeCollection);
        $this->assertTrue($this->entity->isDead());
    }
}