<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 18:48
 */

namespace Player\Entity;


use Player\EntityInterface;

class Hero extends BasicEntity
{
    private $name = 'Unnamed hero';

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

}