<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 23:14
 */

namespace Match\Observer;


use Match\Broadcaster\BroadcasterInterface;

interface ObserverInterface
{
    public function listen($message);
    public function subscribe(BroadcasterInterface $subject);
}