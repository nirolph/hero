<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 18:33
 */

namespace Player\Stats;


interface StatsInterface
{
    public function getHealth();
    public function setHealth($health);
    public function getStrength();
    public function setStrength($strength);
    public function getDefence();
    public function setDefence($defence);
    public function getSpeed();
    public function setSpeed($speed);
    public function getLuck();
    public function setLuck($luck);
}