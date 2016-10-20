<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 20.10.2016
 * Time: 16:53
 */

namespace Test\Player\Entity;


use PHPUnit\Framework\TestCase;
use Skill\DefendSkill;
use Skill\MagicShieldSkill;
use Skill\RapidStrikeSkill;
use Skill\Service\OptimalSkillSelectorService;
use Player\Stats\PlayerStats;
use Skill\SkillCollection;
use Match\Broadcaster\MessageBroadcaster;
use Skill\Service\Chance\LuckyService;
use Strike\StrikeCollection;
use Strike\BasicStrike;

class BasicEntitySpecialSkillsTest extends TestCase
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
     * Assert that the entity can correctly use the Rapid Strike skill when lucky
     * @throws \Exception
     */
    public function testCanUseRapidStrikeSkillWithLuck()
    {
        $optimalSkillSelector = new OptimalSkillSelectorService();
        $this->entity->setOptimalSkillSelector($optimalSkillSelector);

        $stats = new PlayerStats();
        $stats->setStrength(30);

        $rapidStrikeSkill = RapidStrikeSkill::attachTo($this->entity);
        $skillCollection = new SkillCollection();
        $skillCollection->add($rapidStrikeSkill);
        $this->entity->setSkills($skillCollection);

        $chance = $this->getMockBuilder(LuckyService::class)
            ->setMethods(['amILucky'])->getMock();
        $chance->method('amILucky')->willReturn(true);
        $rapidStrikeSkill->setChance($chance);

        $broadcaster = $this->getMockBuilder(MessageBroadcaster::class)
            ->setMethods(['broadcast'])->getMock();
        $broadcaster->method('broadcast')->willReturn('');
        $this->entity->setBroadcaster($broadcaster);
        $rapidStrikeSkill->setBroadcaster($broadcaster);

        $this->entity->setStats($stats);
        $strikes = $this->entity->attack();

        $totalDamage = 0;
        $totalStrikes = 0;

        foreach ($strikes as $strike) {
            ++$totalStrikes;
            $totalDamage += $strike->getPower();
        }

        $this->assertEquals(60, $totalDamage);
        $this->assertEquals(2, $totalStrikes);
    }

    /**
     * Assert that the Rapid Strike skill is not effective when unlucky
     * @throws \Exception
     */
    public function testCanUseRapidStrikeSkillWithoutLuck()
    {
        $optimalSkillSelector = new OptimalSkillSelectorService();
        $this->entity->setOptimalSkillSelector($optimalSkillSelector);

        $stats = new PlayerStats();
        $stats->setStrength(30);

        $rapidStrikeSkill = RapidStrikeSkill::attachTo($this->entity);
        $skillCollection = new SkillCollection();
        $skillCollection->add($rapidStrikeSkill);
        $this->entity->setSkills($skillCollection);

        $chance = $this->getMockBuilder(LuckyService::class)
            ->setMethods(['amILucky'])->getMock();
        $chance->method('amILucky')->willReturn(false);
        $rapidStrikeSkill->setChance($chance);

        $broadcaster = $this->getMockBuilder(MessageBroadcaster::class)
            ->setMethods(['broadcast'])->getMock();
        $broadcaster->method('broadcast')->willReturn('');
        $this->entity->setBroadcaster($broadcaster);
        $rapidStrikeSkill->setBroadcaster($broadcaster);

        $this->entity->setStats($stats);
        $strikes = $this->entity->attack();
        $this->assertEmpty($strikes);
    }

    /**
     * Assert that the entity can correctly use the Magic Shield skill when lucky
     * @throws \Exception
     */
    public function testCanUseMagicShieldSkillWithLuck()
    {
        $strikeCollection = new StrikeCollection();
        $strike = $this->getMockBuilder(BasicStrike::class)->setMethods(['getPower'])->getMock();
        $strike->method('getPower')->will($this->returnValue(50));
        $strikeCollection->add($strike);

        $optimalSkillSelector = new OptimalSkillSelectorService();
        $this->entity->setOptimalSkillSelector($optimalSkillSelector);

        $stats = new PlayerStats();
        $stats->setHealth(100);
        $stats->setDefence(10);

        $skillCollection = new SkillCollection();
        $magicShieldSkill = MagicShieldSkill::attachTo($this->entity);
        $skillCollection->add($magicShieldSkill);
        $this->entity->setSkills($skillCollection);

        $chance = $this->getMockBuilder(LuckyService::class)
            ->setMethods(['amILucky'])->getMock();
        $chance->method('amILucky')->willReturn(true);
        $magicShieldSkill->setChance($chance);

        $broadcaster = $this->getMockBuilder(MessageBroadcaster::class)
            ->setMethods(['broadcast'])->getMock();
        $broadcaster->method('broadcast')->willReturn('');
        $this->entity->setBroadcaster($broadcaster);
        $magicShieldSkill->setBroadcaster($broadcaster);

        $this->entity->setStats($stats);
        $this->entity->method('lucky')->willReturn(false);

        $this->entity->defend($strikeCollection);
        $this->assertEquals(80, $this->entity->getStats()->getHealth());
    }

    /**
     * Assert that the Magic Shield skill is not effective when unlucky
     * @throws \Exception
     */
    public function testCanUseMagicShieldSkillWithoutLuck()
    {
        $strikeCollection = new StrikeCollection();
        $strike = $this->getMockBuilder(BasicStrike::class)->setMethods(['getPower'])->getMock();
        $strike->method('getPower')->will($this->returnValue(50));
        $strikeCollection->add($strike);

        $optimalSkillSelector = new OptimalSkillSelectorService();
        $this->entity->setOptimalSkillSelector($optimalSkillSelector);

        $stats = new PlayerStats();
        $stats->setHealth(100);
        $stats->setDefence(10);

        $skillCollection = new SkillCollection();
        $magicShieldSkill = MagicShieldSkill::attachTo($this->entity);
        $defendSkill = DefendSkill::attachTo($this->entity);
        $skillCollection->add($magicShieldSkill);
        $skillCollection->add($defendSkill);
        $this->entity->setSkills($skillCollection);

        $chance = $this->getMockBuilder(LuckyService::class)
            ->setMethods(['amILucky'])->getMock();
        $chance->method('amILucky')->willReturn(false);
        $magicShieldSkill->setChance($chance);

        $broadcaster = $this->getMockBuilder(MessageBroadcaster::class)
            ->setMethods(['broadcast'])->getMock();
        $broadcaster->method('broadcast')->willReturn('');
        $this->entity->setBroadcaster($broadcaster);
        $magicShieldSkill->setBroadcaster($broadcaster);
        $defendSkill->setBroadcaster($broadcaster);

        $this->entity->setStats($stats);
        $this->entity->method('lucky')->willReturn(false);

        $this->entity->defend($strikeCollection);
        $this->assertEquals(60, $this->entity->getStats()->getHealth());
    }
}