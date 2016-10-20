<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 20.10.2016
 * Time: 19:36
 */

namespace Match\Observer;

/**
 * Interface RendererInterface
 * @package Match\Observer
 */
interface RendererInterface
{
    /**
     * Render messages
     * @param array $output
     * @return mixed
     */
    public function render(array $output);
}