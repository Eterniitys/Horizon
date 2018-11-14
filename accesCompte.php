<?php
include 'init.php';

if (!empty($_POST)){
	$mail=htmlspecialchars($_POST['email']);
	$mdp=sha1(htmlspecialchars($_POST['mdp']));
# SQL
	if (empty($mail) && empty($mdp)){
		#Tous les champs ne sont pas remplis
		echo "<script>alert(\"Tous les champs ne sont pas remplis\")</script>";
	}else{
		$sql='select * from utilisateurs where mail=\''.$mail.'\'';
		$info=$connexion->query($sql)->fetch(PDO::FETCH_ASSOC);
		if (!empty($info) && $mdp === $info['mdp']){
			#Acces validé, je compléte la session
			$_SESSION['id_utilisateur']=$info['id_utilisateur'];
			$_SESSION['nom']=$info['nom'];
			$_SESSION['prenom']=$info['prenom'];
			$_SESSION['email']=$info['mail'];
			#Vérification de la table Admin
			$sql='select * from administrateurs where id_utilisateur='.$_SESSION['id_utilisateur'];
			$info=$connexion->query($sql)->fetch(PDO::FETCH_ASSOC);
			if(!empty($info)){
				$_SESSION['admin']=true;
			}
			header('location:index.php');
		}else{
			#Il n'y à pas de resultat correspondant a l'adresse mail
			echo "<script>alert(\"Une erreur de saisi ? Recommencez.\")</script>";
		}
	}
}

?>
<?php
#echo '<pre>';
#print_r($info);
#print_r($_POST);
#print_r($_SESSION);
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
							<section>
								<h2>Connexion</h2>
								<form method="post" action="accesCompte.php">
									<div class="fields">
										<div class="field">
											<input type="email" name="email" value="<?=$_SESSION['email']?>" placeholder="Email" />
										</div>
										<div class="field half">
											<input type="password" name="mdp" placeholder="Mot de Passe" />
										</div>
									</div>
									<ul class="actions">
										<li><input type="submit" name="send" value="C'est parti !" class="medium" /></li>
										<li><a href="inscription.php" class="button primary medium">Je veux m'incrire moi.</a></li>
									</ul>
								</form>
							</section>
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
