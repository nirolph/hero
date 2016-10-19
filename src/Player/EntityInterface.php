<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 19:57
 */

namespace Player;


use Match\Broadcaster\BroadcasterInterface;
use Player\Stats\StatsAwareInterface;
use Skill\Service\Chance\ChanceAwareInterface;
use Skill\Service\OptimalSkillSelectorAwareInterface;

interface EntityInterface extends OffensiveInterface, SkilledInterface,
    DefensiveInterface, LuckyInterface, ChanceAwareInterface,
    StatsAwareInterface, OptimalSkillSelectorAwareInterface
{
    public function isDead();
    public function getName();
    public function setName($name);
}