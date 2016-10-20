<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 19:57
 */

namespace Player;


use Player\Stats\StatsAwareInterface;
use Skill\Service\Chance\ChanceAwareInterface;
use Skill\Service\OptimalSkillSelectorAwareInterface;

interface EntityInterface extends OffensiveInterface, SkilledInterface,
    DefensiveInterface, LuckyInterface, ChanceAwareInterface,
    StatsAwareInterface, OptimalSkillSelectorAwareInterface
{
    /**
     * Is the player dead?
     * @return bool
     */
    public function isDead();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param $name
     */
    public function setName($name);
}