<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../scripts/order.php"; $bst = new BESTELLUNG;

header("Access-Control-Allow-Origin:*");
header("Content-type: application/json; charset=utf-8");

$request = json_decode(file_get_contents('php://input'));
$customer = array_pop($request);

//var_dump($request);
//var_dump($customer);

$bst->sendOrder(json_encode($request), $customer);