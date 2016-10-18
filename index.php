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

$heroFactory = new \Player\Factory\OrderusHeroFactory();
$beastFactory = new \Player\Factory\BeastFactory();

$orderus = $heroFactory->create();
$beast = $beastFactory->create();

dump($orderus->getName());
dump($orderus->getStats());
dump($beast->getName());
dump($beast->getStats());

$attack = $orderus->attack();
$beast->defend($attack);

dump($orderus->getName());
dump($orderus->getStats());
dump($beast->getName());
dump($beast->getStats());