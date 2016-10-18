<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 18:19
 */

namespace Player;

use Strike\StrikeCollection;

interface DefensiveInterface
{
    /**
     * Defend against a strike
     * @param StrikeCollection $strike
     * @return mixed
     */
    public function defend(StrikeCollection $strike);
}