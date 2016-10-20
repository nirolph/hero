<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 18:19
 */

namespace Player;

use Strike\StrikeCollection;

/**
 * Ability to defend against a strike
 * Interface DefensiveInterface
 * @package Player
 */
interface DefensiveInterface
{
    /**
     * Defend against a strike
     * @param StrikeCollection $strike
     * @return mixed
     */
    public function defend(StrikeCollection $strike);
}