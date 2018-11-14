<?php
include 'init.php';

if (!empty($_POST)){
	$_SESSION['nom']=htmlspecialchars($_POST['nom']);
	$_SESSION['prenom']=htmlspecialchars($_POST['prenom']);
	$_SESSION['email']=htmlspecialchars($_POST['email']);
}
#CONSTANTE
$pattern= '#^(['\w']+\.)*(['\w']+)@(['\w']+)(\.(com|fr|gf|pf))$#';


# SQL
$mdp1 = sha1(htmlspecialchars($_POST['mdp1']));
$mdp2 = sha1(htmlspecialchars($_POST['mdp2']));
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$mail = $_SESSION['email'];

if (!empty($_POST) && $mdp1 === $mdp2){
	if (empty($nom) || empty($prenom) || empty($mail) || empty($_POST['mdp1'])){
		echo "<script>alert(\"Tous les champs ne sont pas remplis\")</script>";
	}else{
		$sql1='insert into utilisateurs(nom, prenom, mail, mdp) values (:nom,:prenom,:email,:mdp)';
		$sql2='select * from utilisateurs where mail=\''.$mail.'\'';
		$info=$connexion->query($sql2)->fetch(PDO::FETCH_ASSOC);
		if (empty($info) && preg_match($pattern,$mail) == 1){
			$info=$connexion->prepare($sql1);
			$info->execute(array('nom'=>$nom,'prenom'=>$prenom,'email'=>$mail,'mdp'=>$mdp1));
			echo "<script>alert(\"Inscription réussi\")</script>";
			$info=$connexion->query($sql2)->fetch(PDO::FETCH_ASSOC);
			$_SESSION['id_utilisateur']=$info['id_utilisateur'];
			header('location:index.php');
		}else{
			echo "<script>alert(\"Votre adresse email est déjà associé à un compte Horizon ou comporte une erreur.\")</script>";
		}
	}
}else{
	if (isset($_POST['send'])){
		echo "<script>alert(\"Mots de passe saisi différent !\")</script>";
	}
}

?>
<?php
#echo '<pre>';
#echo($info);
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
								<h2>Inscription</h2>
								<form method="post" action="inscription.php">
									<div class="fields">
										<div class="field third">
											<input type="text" name="nom" value="<?=$_SESSION['nom']?>" placeholder="Nom" />
										</div>
										<div class="field third">
											<input type="text" name="prenom" value="<?=$_SESSION['prenom']?>" placeholder="Prénom" />
										</div>
										<div class="field half">
											<input type="email" name="email" value="<?=$_SESSION['email']?>" placeholder="Email" />
										</div>
										<div class="field half"></div>
										<div class="field half">
											<input type="password" name="mdp1" placeholder="Mot de Passe" />
										</div>
										<div class="field half">
											<input type="password" name="mdp2" placeholder="Répéter votre Mot de Passe" />
										</div>
									</div>
									<ul class="actions">
										<li><input type="submit" name="send" value="C'est bon. Inscrivez-moi !" class="primary" /></li>
										<li><a href="accesCompte.php" class="button medium">Hey ! Je suis déjà inscrit.</a></li>
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
