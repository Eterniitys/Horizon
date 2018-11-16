<?php
include "connexion_postgres.php";
$connexion = connexion();

#Session
session_start();

$sql="select * from concerts where id_concert = -1";
foreach ($_SESSION['panier'] as $k=>$v){
	$panier[$k] = $v;
	$sql.="or id_concert=".$k;
}
$info = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
$tot=0; #cout total
foreach ($info as $k=>$v){
	if (isset($panier[$v['id_concert']])){
		$info[$k]['qte_reserv'] = $panier[$v['id_concert']];
		$tot += $info[$k]['qte_reserv']*$v['prix'];
	}
}

?>
<?php
echo '<pre>';
#print_r($info[0]);
#print_r($panier);
echo '</pre>';
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
							<p class="icon fa-shopping-cart fa-5x" style="width:100%;margin:0;text-align: center;"></p>
							<h1>Mon Panier</h1>
							<?php if (!empty($panier)) :?>
								<div class="table-wrapper">
									<table>
										<thead>
											<tr>
												<th>Localisation</th>
												<th>Date</th>
												<th>Places reservée</th>
												<th>coût/place</th>
												<th>coût total</th>
											</tr>
										</thead>
									<tbody>
									<?php foreach ($info as $i => $tab):?>
										<tr>
											<td><a href="vue-concert.php?concert=<?=$tab['id_concert']?>"><?=$tab['lieu']?></a></td>
											<td><?=$tab['date_evenement']?></td>
											<td><?=$tab['qte_reserv']?></td>
											<td><?=$tab['prix']?> €</td>
											<td><?=$tab['prix']*$tab['qte_reserv']?> €</td>
										</tr>
									<?php endforeach;?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="4"></td>
											<td><?=$tot?> €</td>
										</tr>
									</tfoot>
									</table>
								</div>
								<?php if($_SESSION['id_utilisateur']>0):?>
								<form method='post' action="traitement.php">
									<input type="hidden"></input>
									<input type="hidden"></input>
									<input type="submit" value="Valider les réservations" class="fit"></input>
								</form>
								<?php else :?>
									<p style="text-align: center;"><strong class="icon fa-unlink"> Vous devez etre connecté pour valider votre commande</strong></p>
									<p><a href="accesCompte.php" class="icon fa-chain button primary fit">Connexion</a></p>
								<?php endif ;?>
							<?php else :?>
							<p style="text-align: center;"><strong>Panier vide</strong></p>
							<p class="icon fa-spin fa-5x fa-circle-o-notch" style="text-align: center;"></p>
							<?php endif ;?>
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


