<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 18:26
 */

namespace Player\Factory;


use Match\Broadcaster\BroadcasterInterface;

/**
 * Player factory
 * Interface FactoryInterface
 * @package Player\Factory
 */
interface FactoryInterface
{
    /**
     * Create a player
     * @return mixed
     */
    public function create();

    /**
     * Add message broadcaster
     * @param BroadcasterInterface $broadcaster
     * @return mixed
     */
    public function addBroadcaster(BroadcasterInterface $broadcaster);
}