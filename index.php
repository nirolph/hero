<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 17:58
 */
require_once "vendor/autoload.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$game = new \Match\HeroGame();
$game->run();