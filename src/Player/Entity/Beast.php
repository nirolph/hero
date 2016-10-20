<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 21:27
 */

namespace Player\Entity;

/**
 * Class Beast
 * @package Player\Entity
 */
class Beast extends BasicEntity
{
    /**
     * Beast's name
     * @var string
     */
    private $name = 'Unnamed beast';

    /**
     * Get beast's name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set beast's name
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}