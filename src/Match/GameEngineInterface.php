<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 19.10.2016
 * Time: 16:35
 */

namespace Match;

/**
 * Interface GameEngineInterface
 * @package Match
 */
interface GameEngineInterface
{
    /**
     * Run the game
     * @return mixed
     */
    public function run();
}