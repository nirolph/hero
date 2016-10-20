<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 20.10.2016
 * Time: 19:37
 */

namespace Match\Observer;


class JsonRenderer implements RendererInterface
{
    public function render(array $output)
    {
        echo "<pre>";
        echo json_encode($output);
    }

}