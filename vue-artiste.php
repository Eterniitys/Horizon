<?php
require "utils.php";
require 'app/concert.php';
use app\Concert;

$connexion = dbConnexion();

$id_artiste = $_GET['artiste'];
echo "$id_artiste-";
#Session
session_start();

# SQL
$sql='select A.*, C.*
	from
	artistes A
	join ensemble_Groupe Eg on Eg.id_artiste = A.id_artiste
	join concerts C on C.id_concert = Eg.id_concert
	where
	A.id_artiste = :id
	order by date_evenement';
$info=$connexion->prepare($sql);

if ($info->execute(array('id'=>$id_artiste))){
	$info=$info->fetchAll(PDO::FETCH_ASSOC);
}else{
	#redirect("vue.php?artistes");
}
echo "$id_artiste-";

## ajout panier
foreach($info as $k=>$v){
	$data[$v['id_concert']] = new app\Concert($v);
}
//TODO classe artiste
//$info = $data;

if (!empty($_GET)){
	foreach ($_GET as $k=>$v){
		$$k = htmlspecialchars($v);
	}
	if (isset($concerts) && isset($place)){
		$_SESSION['panier'][$concerts] += $place;
		$data[$concerts]->modFrPl(-$place);
		$data[$concerts]->update();
		message('Les places ont été ajoutées au panier');
		redirect('vue-artiste.php?artiste='.$id_artiste);
	}
}

?>
<?php
#echo 'data :<br>'; preTab($data);
#echo 'info :<br>'; preTab($info);
#echo 'info :<br>'; preTab($_SESSION);
?>
<!DOCTYPE HTML>
<!--
	Phantom by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Horizon</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">
		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header + menu -->
				<?php require 'header.php' ;?>

				<!-- Main -->
					<div id="main">
						<div class="inner">
							<span class="image main"><img src="<?='images/banner/'.$info['0']['image']?>" alt="" /></span>
							<h1>En concert avec <?=$info['0']['nom']?></h1>
							<div class="table-wrapper">
								<table>
									<thead>
										<tr>
											<th>Localisation</th>
											<th>Date</th>
											<th>Places restante</th>
											<th>Prix</th>
											<th>Panier</th>
										</tr>
									</thead>
								<tbody>
								<?php foreach ($data as $i => $tab):?>
									<tr>
										<td><a href="vue-concert.php?concert=<?=$i?>"><?=$tab->getLieu()?></a></td>
										<td><?=$tab->getDate_evenement()?></td>
										<td><?=$tab->getPlace_libre().'/'.$tab->getPlace()?></td>
										<td><?=$tab->getPrix()?></td>
										<td>
											<?php if($tab->getPlace_libre()>=1):?>
											<a href="vue-artiste.php?artiste=<?=$id_artiste?>&concerts=<?=$i?>&place=+1" class="button primary small">+1 place</a>
											<?php endif; if($tab->getPlace_libre()>=2):?>
											<a href="vue-artiste.php?artiste=<?=$id_artiste?>&concerts=<?=$i?>&place=+2" class="button small">+2 places</a>
											<?php endif ;?>
										</td>
									</tr>
								<?php endforeach;?>
								</tbody>
								</table>
							</div>
						</div>
					</div>
				<!-- Footer -->
					<?php require 'footer.php'; ?>
			</div>
		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>

