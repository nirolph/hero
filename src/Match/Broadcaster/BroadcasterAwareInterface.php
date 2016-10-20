<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 23:27
 */

namespace Match\Broadcaster;

/**
 * A means to work with a BroadcasterInterface object
 *
 * Interface BroadcasterAwareInterface
 * @package Match\Broadcaster
 */
interface BroadcasterAwareInterface
{
    /**
     * @param BroadcasterInterface $broadcaster
     * @return mixed
     */
    public function setBroadcaster(BroadcasterInterface $broadcaster);

    /**
     * @return BroadcasterInterface
     */
    public function getBroadcaster();
}