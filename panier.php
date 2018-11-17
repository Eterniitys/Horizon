<?php
include "utils.php";
require "app/concert.php";
use app\Concert;
$connexion = dbConnexion();

#Session
start_session_once();

# pour supprimer du panier
if (!empty($_POST)){
	$tmp = app\Concert::getDBconcert($_POST['panier_spr']);
	$tmp->modFrPl($_SESSION['panier'][$_POST['panier_spr']]);
	$tmp->update();
	unset($_SESSION['panier'][$_POST['panier_spr']]);
	unset($tmp);
}

$sql="select * from concerts where id_concert = -1";
foreach ($_SESSION['panier'] as $k=>$v){
	$panier[$k] = app\Concert::getDBconcert($k);
}
$tot=0; #cout total
foreach ($_SESSION['panier'] as $k=>$v){
	$tot += $panier[$k]->getPrix()*$v;
}

preTab($tmp);
preTab($panier);
preTab($_SESSION);
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
								<!-- Si panier non vide -->
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
									<?php foreach ($panier as $i => $tab):?>
										<tr>
											<td><a href="vue-concert.php?concert=<?=$i?>"><?=$tab->getLieu()?></a></td>
											<td><?=$tab->getDate_evenement()?></td>
											<td><?=$_SESSION['panier'][$i]?></td>
											<td><?=$tab->getPrix()?> €</td>
											<td><?=$tab->getPrix()*$_SESSION['panier'][$i]?> €</td>
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
								<!-- Si connecté -->
								<form method='post' action="commander.php">
									<input type="hidden"></input>
									<input type="hidden"></input>
									<input type="submit" value="Continuer" class="fit primary"></input>
								</form>
								<?php else :?>
								<!-- Si non connecté -->
									<p style="text-align: center;"><strong class="icon fa-unlink"> Vous devez etre connecté pour valider votre commande</strong></p>
									<p><a href="accesCompte.php" class="icon fa-chain button primary fit">Connexion</a></p>
								<?php endif ;?>
								<!-- pour supprimer du panier -->
								<form method='post' action="panier.php" class="fields">
									<select name="panier_spr">
										<option value="">- Concert -</option>
										<?php foreach($panier as $concert=>$descrip):?>
											<option value="<?=$concert?>"><?=$descrip->getLieu()?> le <?=$descrip->getDate_evenement()?> - <?=$_SESSION['panier'][$concert]?> places</option>
										<?php endforeach;?>
									</select>
									<input type="submit" value="supprimer du panier" class="fit small"></input>
								</form>
							<?php else :?>
							<!-- Si panier vide -->
							<p style="text-align: center;"><strong>Hooo non ! Votre Panier est vide !</strong></p>
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


