<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 23:14
 */

namespace Match\Observer;


use Match\Broadcaster\BroadcasterInterface;

/**
 * Receives messages from a message broadcaster
 * Interface ObserverInterface
 * @package Match\Observer
 */
interface ObserverInterface
{
    /**
     * Receive incoming message
     * @param $message
     */
    public function listen($message);

    /**
     * Subscribe to a message broadcaster
     * @param BroadcasterInterface $subject
     */
    public function subscribe(BroadcasterInterface $subject);

    /**
     * Output gathered messages
     */
    public function outputRoundStats();
}