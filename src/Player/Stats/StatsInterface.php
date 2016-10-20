<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 18:33
 */

namespace Player\Stats;

/**
 * Interface StatsInterface
 * @package Player\Stats
 */
interface StatsInterface
{
    /**
     * @return int
     */
    public function getHealth();

    /**
     * @param $health
     * @return int
     */
    public function setHealth($health);

    /**
     * @return int
     */
    public function getStrength();

    /**
     * @param $strength
     * @return int
     */
    public function setStrength($strength);

    /**
     * @return int
     */
    public function getDefence();

    /**
     * @param $defence
     * @return int
     */
    public function setDefence($defence);

    /**
     * @return int
     */
    public function getSpeed();

    /**
     * @param $speed
     * @return int
     */
    public function setSpeed($speed);

    /**
     * @return int
     */
    public function getLuck();

    /**
     * @param $luck
     * @return int
     */
    public function setLuck($luck);
}