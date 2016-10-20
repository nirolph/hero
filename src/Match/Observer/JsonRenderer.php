<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 20.10.2016
 * Time: 19:37
 */

namespace Match\Observer;

/**
 * Output messages in json format
 * Class JsonRenderer
 * @package Match\Observer
 */
class JsonRenderer implements RendererInterface
{
    /**
     * Render messages
     * @param array $output
     */
    public function render(array $output)
    {
        echo "<pre>";
        echo json_encode($output);
    }

}