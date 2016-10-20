<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 20.10.2016
 * Time: 18:04
 */

namespace Test\Skill;

use PHPUnit\Framework\TestCase;
use Match\Broadcaster\MessageBroadcaster;
use Player\Stats\PlayerStats;
use Skill\Service\Chance\LuckyService;
use Skill\RapidStrikeSkill;
use Player\Entity\Beast;

class RapidStrikeSkillTest extends TestCase
{
    public function testAttackWithLuck()
    {
        $stats = $this->getMockBuilder(PlayerStats::class)
            ->setMethods(['getStrength'])->getMock();
        $stats->method('getStrength')->willReturn(50);

        $entity = $this->getMockBuilder(Beast::class)
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
        $attackSkill = new RapidStrikeSkill($entity);
        $attackSkill->setBroadcaster($broadcaster);
        $attackSkill->setChance($chance);
        $attackSkill->getOffenseEffectiveness();
        $strikeCollection = $attackSkill->attack();

        $totalPower = 0;
        $totalStrikes = 0;

        foreach ($strikeCollection as $strike) {
            ++$totalStrikes;
            $totalPower += $strike->getPower();
        }

        $this->assertEquals(2, $totalStrikes);
        $this->assertEquals(100, $totalPower);
    }

    public function testCannotAttackWithoutLuck()
    {
        $stats = $this->getMockBuilder(PlayerStats::class)
            ->setMethods(['getStrength'])->getMock();
        $stats->method('getStrength')->willReturn(50);

        $entity = $this->getMockBuilder(Beast::class)
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
        $attackSkill = new RapidStrikeSkill($entity);
        $attackSkill->setBroadcaster($broadcaster);
        $attackSkill->setChance($chance);
        $attackSkill->getOffenseEffectiveness();
        $strikeCollection = $attackSkill->attack();

        $this->assertEmpty($strikeCollection);
    }
}