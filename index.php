<?php
include 'init.php';

if (!isset($_SESSION[id_utilisateur])){
	$_SESSION[id_utilisateur]=-1;
}


# SQL
$sql='select A.*, count (Eg.id_concert) as nbConcert
	from
		artistes A
		join ensemble_Groupe Eg on Eg.id_artiste = A.id_artiste
	group by A.id_artiste 
	order by random() limit 3';

$info=$connexion->query($sql);
$info=$info->fetchAll(PDO::FETCH_ASSOC);

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
							<header>
								<h1>Bienvenue sur Horizon,</br > le site parfait où choisir un concert avec vos amis.</h1>
								<p>Etiam quis viverra lorem, in semper lorem. Sed nisl arcu euismod sit amet nisi euismod sed cursus arcu elementum ipsum arcu vivamus quis venenatis orci lorem ipsum et magna feugiat veroeros aliquam. Lorem ipsum dolor sit amet nullam dolore.</p>
							</header>
							<section class="tiles">
								<?php foreach ($info as $i => $tab):?>
								<article class="style<?=rand(1,6)?>">
									<span class="image">
										<img src="<?='images/artistes/'.$tab[image]?>" alt="" />
									</span>
									<a href="vue-artiste.php?artiste=<?=$tab[id_artiste]?>">
										<h2><?=$tab[nom]?></h2>
										<div class="content">
											<p><?=$tab[nbconcert]?> concerts disponible</p>
										</div>
									</a>
								</article>
								<?php endforeach ;?>
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
