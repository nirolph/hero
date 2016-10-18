<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 23:27
 */

namespace Match\Broadcaster;


interface BroadcasterAwareInterface
{
    public function setBroadcaster(BroadcasterInterface $broadcaster);
    public function getBroadcaster();
}