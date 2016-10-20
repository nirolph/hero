<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 23:20
 */

namespace Match\Broadcaster;


use Match\Observer\ObserverInterface;

/**
 * Implementation of a message broadcaster
 * Class MessageBroadcaster
 * @package Match\Broadcaster
 */
class MessageBroadcaster implements BroadcasterInterface
{
    /**
     * Array of ObserverInterface objects
     * @var array
     */
    private $observers = [];

    /**
     * @param ObserverInterface $observer
     */
    public function addObserver(ObserverInterface $observer)
    {
        $this->observers[] = $observer;
    }

    /**
     * Broadcast a message to all observers
     * @param $message
     */
    public function broadcast($message)
    {
        foreach ($this->observers as $observer) {
            $observer->listen($message);
        }
    }

}