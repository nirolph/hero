<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 18:24
 */

namespace Strike;

/**
 * Class StrikeCollection
 * @package Strike
 */
class StrikeCollection implements \Iterator
{
    /**
     * @var array
     */
    private $strikes = [];

    /**
     * @var int
     */
    private $position = 0;

    /**
     * @param StrikeInterface $strike
     */
    public function add(StrikeInterface $strike)
    {
        $this->strikes[] = $strike;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->strikes[$this->position];
    }

    /**
     * Advance cursor position
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return isset($this->strikes[$this->position]);
    }

    /**
     * Reset cursor position
     */
    public function rewind()
    {
        $this->position = 0;
    }

}