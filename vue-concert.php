<?php
require "app/concert.php";
use app\Concert;

require 'utils.php';
if (isset($_GET['concert']) && $_GET['concert'] >= 0 && $_GET['concert'] != NULL){
	$id_concert = $_GET['concert'];
}else{
	header('location:index.php');
}

$connexion = dbConnexion();

#Session
start_session_once();

# SQL
$sql='select A.*, C.*
	from
		artistes A
		full join ensemble_Groupe Eg on Eg.id_artiste = A.id_artiste
		full join concerts C on C.id_concert = Eg.id_concert
	where
		C.id_concert = :id
	--order by random()  limit 6';
	
$info=$connexion->prepare($sql);

if ($info->execute(array('id'=>$id_concert))){
	$info=$info->fetchAll(PDO::FETCH_ASSOC);
	$concert=Concert::getDBconcert($id_concert);
}else{
	redirect("vue.php?concerts");
}

if(!empty($_POST)){
	$_SESSION['panier'][$id_concert] += $_POST['qte'];
	$concert->modFrPl(-$_POST['qte']);
	$concert->update();
	message('Les places ont été ajoutées au panier');
}

?>
<?php
#preTab($concert);
#preTab($_POST);
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
							<h1><?=$concert->getLieu()?> le <?=dateFr($concert->getDate_evenement())?></h1>
							<form action="#" method='post'>
								<select name='qte' style="width:20%;display:inline-block">
									<?php if($concert->getPlace_libre()>=1):?>
									<option value='1'>1 place</option>
									<?php endif ; if($concert->getPlace_libre()>=2):?>
									<option value='2'>2 places</option>
									<?php endif ; if($concert->getPlace_libre()>=3):?>
									<option value='3'>3 places</option>
									<?php endif ; if($concert->getPlace_libre()>=4):?>
									<option value='4'>4 places</option>
									<?php endif ; if($concert->getPlace_libre()>=5):?>
									<option value='5'>5 places</option>
									<?php endif ; if($concert->getPlace_libre()>=6):?>
									<option value='6'>6 places</option>
									<?php endif ;?>
								</select>
								<input type="submit" class="button primary medium" value="Ajouter au panier"></input>
							</form>
							<p>
								Encore <strong><?=$concert->getPlace_libre()?></strong> places disponibles
							</p>
							<p>
								<?=$concert->getDescription()?>
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
