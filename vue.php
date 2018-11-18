<?php
include "utils.php";
require "app/concert.php";
use app\Concert;
$connexion = dbConnexion();

#Session
session_start();
foreach ($_GET as $k=>$v){
	$$k = htmlspecialchars($v);
}
# SQL
$artistes=false;
if (isset($_GET['artistes'])){
	$sql='select * from artistes A';
	$artistes=true;
}else if(isset($_GET['concerts'])){
	$sql='select * from concerts C order by date_evenement';
}else{
	header('location:index.php');
}

$info=$connexion->query($sql);
$info=$info->fetchAll(PDO::FETCH_ASSOC);

if (isset($concerts)){
	foreach($info as $k=>$v){
		$data[$v['id_concert']] = new app\Concert($v);
	}
	//TODO classe artiste
	$info = $data;
}


?>
<?php
#echo 'data :<br>'; preTab($data);
#echo 'info :<br>'; preTab($info[1]);
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
							<span class="image main"><img src="images/banner/concert-musique.png" alt="" /></span>
							<?php if (!$artistes):?>
							<h1>Tous les concerts</h1>
							<?php else :?>
							<h1>Tous les artistes</h1>
							<?php endif ;?>
							
							<div class="table-wrapper">
								<table>
									<thead>
										<tr>
											<?php if (!$artistes):?>
											<th>Localisation</th>
											<th>Date</th>
											<th>Places restante</th>
											<th>Prix</th>
											<?php else :?>
											<th>Artiste present</th>
											<th>Genre</th>
											<?php endif ;?>
										</tr>
									</thead>
								<tbody>
								<?php foreach ($info as $i => $tab):?>
									<tr>
										<?php if (!$artistes):?>
										<!-- si c'est les concerts -->
										<td><a href="vue-concert.php?concert=<?=$i?>"><?=$tab->getLieu()?></a></td>
										<td><?=$tab->getDate_evenement()?></td>
										<td><?=$tab->getPlace_libre().'/'.$tab->getPlace()?></td>
										<td><?=$tab->getPrix()?></td>
										<td>
											<?php if($tab->getPlace_libre()>=1):?>
											<a href="vue-concert.php?concert=<?=$i?>" class="button primary small">Réserver</a>
											<?php else :?>
											<a href="" class="button small disabled">Victime de son succés</a>
											<?php endif ;?>
										</td>
										<?php else :?>
										<!-- si c'est les artistes -->
										<td><a href="vue-artiste.php?artiste=<?=$tab['id_artiste']?>"><?=$tab['nom']?></a></td>
										<td><?=$tab['genre']?></td>
										<?php endif ;?>
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
