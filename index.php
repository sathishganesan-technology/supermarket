<?php
session_start();
require_once("dbmanager/databasebmanager.php");
$db_handle = new DatabaseManager();
include_once("model/databasemodel.php");
$db_model = new DatabaseModel();

require_once("cartmanager.php");
$checkout = new Cartmanager($db_handle, $db_model);
include_once("managecart.php");
include_once('views/cart_view.php'); 




?>


