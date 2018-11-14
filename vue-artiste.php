<?php
if (isset($_GET['artiste']) && $_GET['artiste'] >= 0 && $_GET['artiste'] != NULL){
	$id_artiste = $_GET['artiste'];
}else{
	header('location:index.php');
}

include "connexion_postgres.php";
$connexion = connexion();

#Session
session_start();

# SQL
$sql='select A.*, C.*
	from
		artistes A
		join ensemble_Groupe Eg on Eg.id_artiste = A.id_artiste
		join concerts C on C.id_concert = Eg.id_concert
	where
		A.id_artiste = '.$id_artiste;

$info=$connexion->query($sql);
$info=$info->fetchAll(PDO::FETCH_ASSOC);

?>
<?php
#echo '<pre>';
#print_r($info);
#echo '</pre>';
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
											<th>Genre</th>
											<th>Places restante</th>
											<th>Prix</th>
										</tr>
									</thead>
								<tbody>
								<?php foreach ($info as $i => $tab):?>
									<tr>
										<td><a href="vue-concert.php?concert=<?=$tab['id_concert']?>"><?=$tab['lieu']?></a></td>
										<td><?=$tab['date_evenement']?></td>
										<td><?=$tab['genre']?></td>
										<td><?=$tab['place_libre'].'/'.$tab['place']?></td>
										<td><?=$tab['prix']?></td>
										<td class='bontonAdd'><a href="#" class="button primary small">Ajouter au panier</a></td>
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
