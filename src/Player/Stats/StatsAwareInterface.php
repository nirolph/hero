<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 21:06
 */

namespace Player\Stats;


interface StatsAwareInterface
{
    public function getStats();
    public function setStats(StatsInterface $stats);
}