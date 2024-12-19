<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['method']))
{
    header('Access-Control-Allow-Origin:*');
    header("Content-type: application/json; charset=utf-8");

    require_once '../scripts/order.php'; $bst = new BESTELLUNG;

    if ($_GET['method'] === 'order-create') if (isset($_GET['content'])) $bst->createOrder($_GET['content']);
    if ($_GET['method'] === 'order-abort') if (isset($_GET['id'])) $bst->abortOrder($_GET['id']);
    if ($_GET['method'] === 'order-update') if (isset($_GET['id']) && isset($_GET['content'])) $bst->updateOrder($_GET['id'], $_GET['content']);
    if ($_GET['method'] === 'order-send') if (isset($_GET['id']) && isset($_GET['content'])) $bst->sendOrder($_GET['id'], $_GET['content']);
    if ($_GET['method'] === 'order-get') echo json_encode($bst->getOrders(), JSON_PRETTY_PRINT);
    if ($_GET['method'] === 'order-getstat') echo json_encode($bst->getOrderStat($_GET["id"]), JSON_PRETTY_PRINT);
    if ($_GET['method'] === 'order-print') $bst->print($_GET["order"]);
    if ($_GET['method'] === 'login') echo json_encode($bst->login($_GET['user'], $_GET['pass']), JSON_PRETTY_PRINT);
}
else 
{
    if (isset($_GET["login"])) include "login.html";
    else include 'index.html';
}

