<?php
include "connexion_postgres.php";
$connexion = connexion();

require 'utils.php';
#Session
session_start();

if (!$_SESSION["admin"]){
	redirect('index.php');
}

$sql = "select * from artistes";
$info = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
foreach($info as $k=>$v){
	foreach($v as $k1=>$v1){
		if($k1 != "id_artiste"){
			$data["artistes"][$v["id_artiste"]][$k1] = $v1;
		}
	}
}
$sql = "select * from concerts";
$info = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
foreach($info as $k=>$v){
	foreach($v as $k1=>$v1){
		if($k1 != "id_concert"){
			$data["concerts"][$v["id_concert"]][$k1] = $v1;
		}
	}
}
$sql = "select * from utilisateurs";
$info = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
foreach($info as $k=>$v){
	foreach($v as $k1=>$v1){
		if($k1 != "id_utilisateur"){
			$data["utilisateurs"][$v["id_utilisateur"]][$k1] = $v1;
		}
	}
}


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");



http_response_code(200);
echo json_encode($data);

?>
