<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 18:48
 */

namespace Player\Entity;

/**
 * Class Hero
 * @package Player\Entity
 */
class Hero extends BasicEntity
{
    /**
     * Hero's name
     * @var string
     */
    private $name = 'Unnamed hero';

    /**
     * Set hero's name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get hero's name
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

}