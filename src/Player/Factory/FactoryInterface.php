<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 18:26
 */

namespace Player\Factory;


interface FactoryInterface
{
    /**
     * Create a player
     * @return mixed
     */
    public function create();
}