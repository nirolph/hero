<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 20.10.2016
 * Time: 19:36
 */

namespace Match\Observer;


interface RendererInterface
{
    public function render(array $output);
}