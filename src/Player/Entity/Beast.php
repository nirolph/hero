<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 21:27
 */

namespace Player\Entity;


class Beast extends BasicEntity
{
    private $name = 'Unnamed beast';

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}