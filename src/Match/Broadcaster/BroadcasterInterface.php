<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 23:17
 */

namespace Match\Broadcaster;


use Match\Observer\ObserverInterface;

interface BroadcasterInterface
{
    public function addObserver(ObserverInterface $observer);
    public function broadcast($message);
}