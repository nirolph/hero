<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 20.10.2016
 * Time: 19:38
 */

namespace Match\Observer;

/**
 * Class SymfonyDumpRenderer
 * @package Match\Observer
 */
class SymfonyDumpRenderer implements RendererInterface
{
    /**
     * Render messages
     * @param array $output
     */
    public function render(array $output)
    {
        dump($output);
    }

}