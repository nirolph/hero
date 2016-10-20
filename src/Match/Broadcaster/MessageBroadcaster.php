<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 23:20
 */

namespace Match\Broadcaster;


use Match\Observer\ObserverInterface;

class MessageBroadcaster implements BroadcasterInterface
{
    private $observers = [];

    public function addObserver(ObserverInterface $observer)
    {
        $this->observers[] = $observer;
    }

    public function broadcast($message)
    {
        foreach ($this->observers as $observer) {
            $observer->listen($message);
        }
    }

}