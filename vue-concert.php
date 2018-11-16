<?php
if (isset($_GET['concert']) && $_GET['concert'] >= 0 && $_GET['concert'] != NULL){
	$id_concert = $_GET['concert'];
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
		full join ensemble_Groupe Eg on Eg.id_artiste = A.id_artiste
		full join concerts C on C.id_concert = Eg.id_concert
	where
		C.id_concert = '.$id_concert.'
	--order by random()  limit 6';

$info=$connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);

if(!empty($_POST)){
	$_SESSION['panier'][$id_concert] = $_POST['qte'];
	echo "<script>alert('Les places ont été ajoutées au panier')</script>";
}

?>
<?php
#echo '<pre>';
#print_r($_SESSION);
#print_r($_POST);
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
							<span class="image main"><img src="<?='images/banner/concert-musique.png'?>" alt="" /></span>
							<h1><?=$info[0]['lieu']?> le <?=$info[0]['date_evenement']?></h1>
							<form action="#" method='post'>
								<select name='qte' style="width:20%;display:inline-block">
									<option value='1'><strong>1 place</strong></option>
									<option value='2'>2 places</option>
									<option value='3'>3 places</option>
									<option value='4'>4 places</option>
									<option value='5'>5 places</option>
									<option value='6'>6 places</option>
								</select>
								<input type="submit" class="button primary medium" value="Ajouter au panier"></input>
							</form>
							<p>
								<?=$info[0]['description']?>
							</p>
							<div class="table-wrapper">
								<table>
									<thead>
										<tr>
											<th>Artiste present</th>
											<th>Genre</th>
										</tr>
									</thead>
								<tbody>
								<?php foreach ($info as $i => $tab):?>
									<tr>
										<td><a href="vue-artiste.php?artiste=<?=$tab['id_artiste']?>"><?=$tab['nom']?></a></td>
										<td><?=$tab['genre']?></td>
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
