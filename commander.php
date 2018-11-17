<?php
include "utils.php";
$connexion = dbConnexion();

#Session
start_session_once();

#variables
$panier = make_safe_array($_SESSION['panier']);

if (isset($_POST['ctn'])){
	$cmd=$connexion->prepare("insert into commande(id_utilisateur) values (:id)");
	$cmd->execute(array('id'=>$_SESSION['id_utilisateur']));
	$l_cmd=$connexion->prepare("insert into ligne_commande(id_commande,id_concerts,nbplace) values ((select max(id_commande) from commande where id_utilisateur=:id ),:id_c,:nb);");
	foreach($panier as $k=>$v){
		$l_cmd->execute(array('id'=>$_SESSION['id_utilisateur'],'id_c'=>$k,'nb'=>$v));
	}
	unset($_SESSION['panier']);
	message("Votre commande à bien été prise en compte");
	redirect('panier.php');
}

if (empty($panier)){
	redirect('index.php');
}
#echo 'session : '; preTab($_SESSION);
#echo 'panier : '; preTab($panier);
#echo 'post : '; preTab($_POST);
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
					<form method='post' action="commander.php" style="text-align:center">
						<img src="images/Paypal.png" alt="" style="margin:10% 0 10% auto;">
						<input type="submit" name='ctn' value="Continuer" class="fit primary"></input>
					</form>
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

