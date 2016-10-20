<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 23:17
 */

namespace Match\Broadcaster;


use Match\Observer\ObserverInterface;

/**
 * A means of broadcasting a message
 *
 * Interface BroadcasterInterface
 * @package Match\Broadcaster
 */
interface BroadcasterInterface
{
    /**
     * @param ObserverInterface $observer
     * @return mixed
     */
    public function addObserver(ObserverInterface $observer);

    /**
     * Broadcast a message
     * @param $message
     */
    public function broadcast($message);
}