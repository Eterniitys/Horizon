<?php
include "connexion_postgres.php";
$connexion = connexion();

#Session
session_start();

if(!isset($_SESSION['admin']) && !$_SESSION['admin'] == true){
	header('location:index.php');			
}
#CONSTANTE chemin image portrait
$pathImg='images/artistes/';
#CONSTANTE chemin image banniére
$pathBanner='images/banner/';

#variables
$category=$_GET['category'];
$type=$_GET['type'];

foreach ($_POST['add'] as $k=>$v){
	$add['$k']=htmlspecialchars($v);
}

# SQL
switch($category){
	#traitement concerts
	case 1:
		switch($type){
			#ajout concert
			case 2:
				$sql='insert into concerts(lieu,date_evenement,place_libre,place,prix,description) values
					(\''.$add[0].'\','.$add[1].',\''.$add[2].'\',\''.$add[2].'\',\''.$add[3].'\',\''.$add[4].'\')';
				break;
			#modification concert
			case 3:
				$sql='update concerts set lieu=\''.$add[0].'\',
					date_evenement=\''.$add[1].'\',place=\''.$add[2].'\',place_libre=\''.$add[3].'\',
					prix=\''.$add[5].'\',description=\''.$add[6].'\' where id_concert='.$add[4];
				$type=2;
				break;
			#suppression concert
			case 4:
				$sql='delete from concerts where id_concert='.$_GET['concert'];
				$type=2;
				break;
		}
		break;
	#traitement artistes
	case 2:
		switch($type){
			#ajout artiste
			case 2:
				move_uploaded_file($_FILES['add']['tmp_name'][0],$pathImg.$add[2]);
				move_uploaded_file($_FILES['add']['tmp_name'][1],$pathBanner.$add[2]);
				$sql='insert into artistes(image,nom,genre) values (\''.$add[2].'\',\''.$add[0].'\',\''.$add[1].'\')';
				break;
			#modification artiste
			case 3:
				if($add[4]!=$add[2]){
					rename($pathImg.$add[4],$pathImg.$add[2]);
					rename($pathBanner.$add[4],$pathBanner.$add[2]);
				}
				if ($_FILES['add']['error'][0]==0){
					if (is_readable($pathImg.$add[2])){
						unlink($pathImg.$add[2]);
					}
					move_uploaded_file($_FILES['add']['tmp_name'][0],$pathImg.$add[2]);
				}
				if ($_FILES['add']['error'][1]==0){
					if (is_readable($pathBanner.$add[2])){
						unlink($pathBanner.$add[2]);
					}
					move_uploaded_file($_FILES['add']['tmp_name'][1],$pathBanner.$add[2]);
				}
				$sql='update artistes set nom=\''.$add[0].'\',genre=\''.$add[1].'\',image=\''.$add[2].'\' where id_artiste='.$add[3];
				$type=2;
				break;
			#suppression artiste
			case 4:
				unlink($pathImg.$_GET['img']);
				unlink($pathBanner.$_GET['img']);
				$sql='delete from artistes where id_artiste='.$_GET['artiste'];
				$type=2;
				break;
		}
		break;
	#traitement participations
	case 3:
		switch($type){
			#ajout participation
			case 2:
				$sql='insert into ensemble_groupe values ('.$_POST['concert'].','.$_POST['artiste'].')';
				break;
			#suppression participation
			case 4:
				$sql='delete from ensemble_groupe where id_artiste='.$_GET['artiste'].' and id_concert='.$_GET['concert'];
				$type=2;
				break;
		}
		break;
	#traitement admins
	case 4:
		switch($type){
			#ajout admin
			case 2:
				$sql='insert into administrateurs(id_utilisateur) values ('.$_GET['utilisateur'].')';
				break;
			#suppression admin
			case 4:
				$sql='delete from administrateurs where id_utilisateur='.$_GET['utilisateur'];
				$type=2;
				break;
		}
		break;
}
if(!empty($sql)){
	$connexion->exec($sql);
}

header('location:gestionSite.php?category='.$category.'&type='.$type);
include 'header.php';
?>
<?php
echo '<pre>';
echo $sql.'<br>';
echo 'get : ';
print_r($_GET);
echo 'post : ';
print_r($_POST);
echo 'add : ';
print_r($add);
echo 'files : ';
print_r($_FILES);
echo '</pre>';
?>
