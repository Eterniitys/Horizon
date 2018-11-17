<?php
session_start();
require "app/concert.php";
use app\Concert;

if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])){
	foreach($_SESSION['panier'] as $k=>$v){
		$tmp = app\Concert::getDBconcert($k);
		$tmp->modFrPl($v);
		$tmp->update();
	}
}

$_SESSION=array();

session_destroy();

header('location:index.php');
?>

