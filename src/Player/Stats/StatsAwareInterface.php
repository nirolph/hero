<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 21:06
 */

namespace Player\Stats;

/**
 * Interface StatsAwareInterface
 * @package Player\Stats
 */
interface StatsAwareInterface
{
    /**
     * Get player stats
     * @return mixed
     */
    public function getStats();

    /**
     * Set player stats
     * @param StatsInterface $stats
     * @return mixed
     */
    public function setStats(StatsInterface $stats);
}