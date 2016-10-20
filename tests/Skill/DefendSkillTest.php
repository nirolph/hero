<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 20.10.2016
 * Time: 17:54
 */

namespace Test\Skill;

use PHPUnit\Framework\TestCase;
use Match\Broadcaster\MessageBroadcaster;
use Player\Stats\PlayerStats;
use Skill\DefendSkill;
use Strike\BasicStrike;

class DefendSkillTest extends TestCase
{
    public function testDefend()
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

        $defendSkill = new DefendSkill($entity);
        $defendSkill->setBroadcaster($broadcaster);

        $strike = $this->getMockBuilder(BasicStrike::class)
            ->setMethods(['getPower'])->getMock();
        $strike->method('getPower')->willReturn(60);

        $defendSkill->defend($strike);
        $this->assertEquals(80, $entity->getStats()->getHealth());
    }
}