<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 20.10.2016
 * Time: 18:14
 */

namespace Test\Skill;

use PHPUnit\Framework\TestCase;
use Match\Broadcaster\MessageBroadcaster;
use Player\Stats\PlayerStats;
use Skill\MagicShieldSkill;
use Strike\BasicStrike;
use Skill\Service\Chance\LuckyService;

class MagicShieldSkillTest extends TestCase
{
    public function testCanDefendWithLuck()
    {
        $stats = new PlayerStats();
        $stats->setHealth(100);
        $stats->setDefence(40);

        $entity = $this->getMockBuilder(\Player\Entity\Beast::class)
            ->setMethods(['getName', 'getStats'])
            ->getMock();
        $entity->method('getName')->willReturn('test beast entity');
        $entity->method('getStats')->willReturn($stats);

        $broadcaster = $this->getMockBuilder(MessageBroadcaster::class)
            ->setMethods(['broadcast'])->getMock();
        $broadcaster->method('broadcast')->willReturn('');
        $entity->setBroadcaster($broadcaster);

        $chance = $this->getMockBuilder(LuckyService::class)
            ->setMethods(['amILucky'])->getMock();
        $chance->method('amILucky')->willReturn(true);

        $defendSkill = new MagicShieldSkill($entity);
        $defendSkill->setBroadcaster($broadcaster);
        $defendSkill->setChance($chance);

        $strike = $this->getMockBuilder(BasicStrike::class)
            ->setMethods(['getPower'])->getMock();
        $strike->method('getPower')->willReturn(60);

        $defendSkill->getDefenceEffectiveness($strike);
        $defendSkill->defend($strike);
        $this->assertEquals(90, $entity->getStats()->getHealth());
    }

    public function testCanDefendWithoutLuck()
    {
        $stats = new PlayerStats();
        $stats->setHealth(100);
        $stats->setDefence(40);

        $entity = $this->getMockBuilder(\Player\Entity\Beast::class)
            ->setMethods(['getName', 'getStats'])
            ->getMock();
        $entity->method('getName')->willReturn('test beast entity');
        $entity->method('getStats')->willReturn($stats);

        $broadcaster = $this->getMockBuilder(MessageBroadcaster::class)
            ->setMethods(['broadcast'])->getMock();
        $broadcaster->method('broadcast')->willReturn('');
        $entity->setBroadcaster($broadcaster);

        $chance = $this->getMockBuilder(LuckyService::class)
            ->setMethods(['amILucky'])->getMock();
        $chance->method('amILucky')->willReturn(false);

        $defendSkill = new MagicShieldSkill($entity);
        $defendSkill->setBroadcaster($broadcaster);
        $defendSkill->setChance($chance);

        $strike = $this->getMockBuilder(BasicStrike::class)
            ->setMethods(['getPower'])->getMock();
        $strike->method('getPower')->willReturn(60);

        $defendSkill->getDefenceEffectiveness($strike);
        $defendSkill->defend($strike);
        $this->assertEquals(100, $entity->getStats()->getHealth());
    }
}