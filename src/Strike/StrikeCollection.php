<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 18:24
 */

namespace Strike;


class StrikeCollection implements \Iterator
{
    private $strikes = [];
    private $position = 0;

    public function add(StrikeInterface $strike)
    {
        $this->strikes[] = $strike;
    }

    public function current()
    {
        return $this->strikes[$this->position];
    }

    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return isset($this->strikes[$this->position]);
    }

    public function rewind()
    {
        $this->position = 0;
    }

}