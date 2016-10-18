<?php

/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 18:19
 */

namespace Player;

use Strike\StrikeCollection;

interface OffensiveInterface
{
    /**
     * Returns a collection of strikes
     * @return StrikeCollection
     */
    public function attack();
}