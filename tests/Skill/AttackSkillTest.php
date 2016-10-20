<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 20.10.2016
 * Time: 17:42
 */

namespace Test\Skill;


use PHPUnit\Framework\TestCase;
use Match\Broadcaster\MessageBroadcaster;
use Player\Stats\PlayerStats;
use Skill\AttackSkill;

class AttackSkillTest extends TestCase
{
    public function testAttack()
    {
        $stats = $this->getMockBuilder(PlayerStats::class)
            ->setMethods(['getStrength'])->getMock();
        $stats->method('getStrength')->willReturn(50);

        $entity = $this->getMockBuilder(\Player\Entity\Beast::class)
            ->setMethods(['getName', 'getStats'])
            ->getMock();
        $entity->method('getName')->willReturn('test beast entity');
        $entity->method('getStats')->willReturn($stats);

        $broadcaster = $this->getMockBuilder(MessageBroadcaster::class)
            ->setMethods(['broadcast'])->getMock();
        $broadcaster->method('broadcast')->willReturn('');
        $entity->setBroadcaster($broadcaster);

        $attackSkill = new AttackSkill($entity);
        $attackSkill->setBroadcaster($broadcaster);
        $strikeCollection = $attackSkill->attack();

        $totalPower = 0;
        $totalStrikes = 0;

        foreach ($strikeCollection as $strike) {
            ++$totalStrikes;
            $totalPower += $strike->getPower();
        }

        $this->assertEquals(1, $totalStrikes);
        $this->assertEquals(50, $totalPower);
    }
}