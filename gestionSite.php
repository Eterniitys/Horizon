<?php
include "connexion_postgres.php";
$connexion = connexion();

#Session
session_start();

if(!isset($_SESSION['admin']) && !$_SESSION['admin'] == true){
	header('location:index.php');			
}

#CONSTANTE signal ajout
$ajout=2;
#CONSTANTE signal modification
$mod=3;
#CONSTANTE signal suppression
$suppr=4;

if(isset($_POST['category']) && isset($_POST['type']) || isset($_GET['category']) && isset($_GET['type'])){
	if (isset($_POST['category']) && isset($_POST['type'])){
		$category = $_POST['category'];
		$type = $_POST['type'];
	}else{
		$category = $_GET['category'];
		$type = $_GET['type'];
	}
# SQL
	#selection de la table
	switch($category){
		case 1:
			$sql ='select * from concerts C';
			if($type==$mod){
				$sql_[0] ='select * from concerts C where C.id_concert='.$_GET['concert'];
			}
			break;
		case 2:
			$sql ='select * from artistes A';
			if($type==$mod){
				$sql_[0] ='select * from artistes A where A.id_artiste='.$_GET['artiste'];
			}
			break;
		case 3:
			$sql ='select * from ensemble_groupe Es
					join concerts Co on Es.id_concert = Co.id_concert
					join artistes Ar on Ar.id_artiste = Es.id_artiste';
			$sql_[0]='select * from artistes';
			$sql_[1]='select * from concerts';
			break;
		case 4:
			$sql ='select * from administrateurs A
					right join utilisateurs U on A.id_utilisateur = U.id_utilisateur';
			break;
		default:
			$category='';
	}
#Gestion de la requete
	if (isset($sql)){
		$info=$connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	}
	if(isset($sql_[0])){
		$info_[0]=$connexion->query($sql_[0])->fetchAll(PDO::FETCH_ASSOC);
	}
	if(isset($sql_[1])){
		$info_[1]=$connexion->query($sql_[1])->fetchAll(PDO::FETCH_ASSOC);
	}
}

?>
<?php
#echo '<pre>';
#print_r($_GET);
#print_r($_SESSION);
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
							<h1>Administration de Horizon</h1>
							<?php if($category!='' && $type!='') :?>
								<!--Gestion en liste, en-tête -->
									<div class="table-wrapper">
									<table>
										<thead>
											<tr>
											<?php switch($category):
												case 1: ?>
												<th>Localisation</th>
												<th>Date</th>
												<?php if($type==1) :?>
												<th>Places restante</th>
												<th>Prix</th>
												<?php endif ;?>
												<?php break ;
												case 2: ?>
												<th>Artiste</th>
												<th>Genre</th>
												<th>Image</th>
												<?php break ;
												case 3: ?>
												<th>Localisation</th>
												<th>Date</th>
												<th>Artiste</th>
												<?php break ;
												case 4: ?>
												<th>Nom</th>
												<th>Prenom</th>
												<th>Mail</th>
											<?php endswitch ;?>
											</tr>
										</thead>
									<tbody>
									<!--Gestion en liste, Cas de l'affichage uniquement-->
									<?php if($category!='' && $type==1) :?>
											<?php foreach ($info as $i => $tab):?>
												<tr>
												<?php switch($category):
													case 1: ?>
													<td><?=$tab['lieu']?></td>
													<td><?=$tab['date_evenement']?></td>
													<td><?=$tab['place_libre'].'/'.$tab['place']?></td>
													<td><?=$tab['prix']?></td>
													<?php break ;
													case 2: ?>
													<td><?=$tab['nom']?></td>
													<td><?=$tab['genre']?></td>
													<td><?=$tab['image']?></td>
													<?php break ;
													case 3: ?>
													<td><?=$tab['lieu']?></td>
													<td><?=$tab['date_evenement']?></td>
													<td><?=$tab['nom']?></td>
													<?php break ;
													case 4: ?>
													<?php if(!empty($tab['id_admin'])) :?>
														<td><?=$tab['nom']?></td>
														<td><?=$tab['prenom']?></td>
														<td><?=$tab['mail']?></td>
													<?php endif ;?>
												<?php endswitch ;?>
												</tr>
											<?php endforeach;?>
									<!--Gestion en liste, Cas de l'affichage avec modification/suppression-->
									<?php else:?>
										<?php switch($category):
											case 1: ?> <!-- concert -->
													<?php foreach ($info as $i => $tab):?>
														<tr>
															<td><?=$tab['lieu']?></td>
															<td><?=$tab['date_evenement']?></td>
															<td><a href="gestionSite.php?category=<?=$category?>&type=<?=$mod?>&concert=<?=$tab['id_concert']?>#mod" class="button small">Modifier concert</a>
															<a href="traitement.php?category=<?=$category?>&type=<?=$suppr?>&concert=<?=$tab['id_concert']?>" class="button small primary">Supprimer concert</a></td>
														</tr>
													<?php endforeach;?>
											<?php break ;
											case 2: ?> <!-- artiste -->
													<?php foreach ($info as $i => $tab):?>
														<tr>
															<td><?=$tab['nom']?></td>
															<td><?=$tab['genre']?></td>
															<td><?=$tab['image']?></td>
															<td><a href="gestionSite.php?category=<?=$category?>&type=<?=$mod?>&artiste=<?=$tab['id_artiste']?>#mod" class="button small">Modifier Artiste</a>
															<a href="traitement.php?category=<?=$category?>&type=<?=$suppr?>&artiste=<?=$tab['id_artiste']?>&img=<?=$tab['image']?>" class="button small primary">Supprimer Artiste</a></td>
														</tr>
													<?php endforeach;?>
											<?php break ;
											case 3: ?>  <!-- participation -->
												<?php foreach ($info as $i => $tab):?>
													<tr>
														<td><?=$tab['lieu']?></td>
														<td><?=$tab['date_evenement']?></td>
														<td><?=$tab['nom']?></td>
														<td><a href="traitement.php?category=<?=$category?>&type=<?=$suppr?>&concert=<?=$tab['id_concert']?>&artiste=<?=$tab['id_artiste']?>" class="button small">Supprimmer participation</a></td>
													</tr>
												<?php endforeach;?>
											<?php break ;
											case 4: ?> <!-- admin -->
												<?php foreach ($info as $i => $tab):?>
													<?php if(!empty($tab['id_admin'])) :?>
														<tr>
															<td><?=$tab['nom']?></td>
															<td><?=$tab['prenom']?></td>
															<td><?=$tab['mail']?></td>
															<?php if($tab['id_admin']!=1 && $tab['id_utilisateur']!=$_SESSION['id_utilisateur']):?>
																<td><a href="traitement.php?category=<?=$category?>&type=<?=$suppr?>&utilisateur=<?=$tab['id_utilisateur']?>" class="button small">Supprimmer droit d'administrateur</a></td>
															<?php else:?>
																<td><a href="traitement.php?category=<?=$category?>&type=<?=$suppr?>&utilisateur=<?=$tab['id_utilisateur']?>" class="button small disabled">Supprimmer droit d'administrateur</a></td>
															<?php endif;?>
														</tr>
													<?php endif ;?>
												<?php endforeach;?>
										<?php endswitch ;?>
									<?php endif;?>
									</tbody>
									</table>
								</div id="mod">
								<!-- Fin gestion en liste -->
								<!-- Gestion de la modification/ajout -->
								<?php if($category!='' && $type!=1) :?>
									<?php if($type==$ajout):?>
										<h2>Ajouter un élément</h2>
									<?php else :?>
										<h2>Modification d'un élément</h2>
									<?php endif ;?>
									<?php switch($category):
										case 1: ?> <!-- Concerts -->
											<form method='post' action='traitement.php?category=<?=$category?>&type=<?=$type?>'>
												<div class="fields">
													<div class="field third">Lieu</div>
													<div class="field third2">
														<input type="text" name="add[]" value="<?=$info_[0][0]['lieu']?>" placeholder="Lieu" require/>
													</div>
													<div class="field third">Date</div>
													<div class="field third2">
														<input type="date" name="add[]" value="<?=$info_[0][0]['date_evenement']?>" placeholder="Lieu" require/>
													</div>
													<div class="field third">Nombre de place total</div>
													<div class="field third2">
														<input type="number" name="add[]" value="<?=$info_[0][0]['place']?>" placeholder="ex : 1234" require/>
													</div>
													<?php if($type==$mod):?>
														<div class="field third">Nombre de place disponible</div>
														<div class="field third2">
															<input type="number" name="add[]" value="<?=$info_[0][0]['place_libre']?>"/>
														</div>
														<input type="hidden" name="add[]" value="<?=$info_[0][0]['id_concert']?>" />
													<?php endif;?>
													<div class="field third">Prix de l'entrée</div>
													<div class="field third2">
														<input type="number" name="add[]" value="<?=$info_[0][0]['prix']?>" step='.01' placeholder="ex : 49,50" require/>
													</div>
													<div class="field">
														<textarea name="add[]" placeholder="Entrez une description" rows="6"><?=$info_[0][0]['description']?></textarea>
													</div>
													<div class="field">
														<ul class="actions">
															<?php if($type==$ajout):?>
																<li><input type="submit" value="Ajouter le concert" class="primary" /></li>
															<?php else :?>
																<li><input type="submit" value="Modifier le concert" class="primary" /></li>
															<?php endif ;?>
															<li><input type="reset" value="Reset" /></li>
														</ul>
													</div>
												</div>
											</form>
										<?php break ;
										case 2: ?> <!-- Artistes -->
											<form method='post' action='traitement.php?category=<?=$category?>&type=<?=$type?>' enctype="multipart/form-data">
												<div class="fields">
													<div class="field third">Nom</div>
													<div class="field third2">
														<input type="text" name="add[]" value="<?=$info_['0']['0']['nom']?>" placeholder="Nom de l'artiste ou du groupe" require/>
													</div>
													<div class="field third">Genre</div>
													<div class="field third2">
														<input type="text" name="add[]" value="<?=$info_['0']['0']['genre']?>" placeholder="ex : Pop, Rock, Pop/Rock, ..." require/>
													</div>
													<div class="field third">Nom des images</div>
													<div class="field third2">
														<input type="text" name="add[]" value="<?=$info_['0']['0']['image']?>" placeholder="ex : monImage.png" />
													</div>
													<div class="field third">Image type "Profile"</div>
													<div class="field third2">
														<input type="file" name="add[]" value="" />
													</div>
													<div class="field third">Image type "Banner"</div>
													<div class="field third2">
														<input type="file" name="add[]" value=""/>
													</div>
													<?php if($type == $mod):?>
														<input type="hidden" name="add[]" value="<?=$info_['0']['0']['id_artiste']?>"/>
														<input type="hidden" name="add[]" value="<?=$info_['0']['0']['image']?>"/>
														<span class="image" style=width:calc(50%) >
															<img src="<?='images/artistes/'.$info_['0']['0']['image']?>" alt=""  style=max-width:calc(100%)>
														</span>
														<span class="image" style=width:calc(50%)>
															<img src="<?='images/banner/'.$info_['0']['0']['image']?>" alt=""  style=max-width:calc(100%)>
														</span>
													<?php endif ;?>
													<div class="field">
														<ul class="actions">
															<?php if($type==$ajout):?>
																<li><input type="submit" value="Ajouter l'Artiste" class="primary" /></li>
															<?php else :?>
																<li><input type="submit" value="Modifier l'Artiste" class="primary" /></li>
															<?php endif ;?>
															<li><input type="reset" value="Reset" /></li>
														</ul>
													</div>
												</div>
											</form>
										<?php break ;
										case 3: ?> <!-- Participation -->
										<form method='post' action='traitement.php?category=<?=$category?>&type=<?=$ajout?>' class="col-12">
											<select name="artiste">
												<option value="">- L'artiste ... -</option>
												<?php foreach($info_['0'] as $k=>$v) :?>
													<option value="<?=$v['id_artiste']?>"><?=$v['nom']?></option>
												<?php endforeach ;?>
											</select>
											<select name="concert">
												<option value="">- Sera présent au concerts à ... le ... -</option>
												<?php foreach($info_['1'] as $k=>$v) :?>
													<option value="<?=$v['id_concert']?>"><?=$v['lieu']?> <strong>le</strong> <?=$v['date_evenement']?></option>
												<?php endforeach ;?>
											</select>
											<div class="field">
												<ul class="actions">
													<li><input type="submit" value="Ajouter l'Artiste au concert" class="primary" /></li>
													<li><input type="reset" value="Reset" /></li>
												</ul>
											</div>
										</form>
										<?php break ;
										case 4: ?> <!-- Admin -->
										<div class="table-wrapper">
											<table>
												<thead>
													<tr>
														<th>Nom</th>
														<th>Prenom</th>
														<th>Mail</th>
													</tr>
												</thead>
											<tbody>
											<?php foreach ($info as $i => $tab):?>
												<?php if(empty($tab['id_admin'])) :?>
													<tr>
														<td><?=$tab['nom']?></td>
														<td><?=$tab['prenom']?></td>
														<td><?=$tab['mail']?></td>
														<td><a href="traitement.php?category=<?=$category?>&type=<?=$ajout?>&utilisateur=<?=$tab['id_utilisateur']?>" class="button small">Promouvoir Administrateur</a></td>
													</tr>
												<?php endif ;?>
											<?php endforeach;?>
											</tbody>
											</table>
										</div>
									<?php endswitch ;?>
								<?php endif ;?>
							<?php endif ;?>
							<form method="post" action="gestionSite.php" class="col-12">
								<select name="category">
									<option value="">- Gestion des ... -</option>
									<option value="1">Gestion des concerts</option>
									<option value="2">Gestion des artistes</option>
									<option value="3">Gestion de la participations des artistes aux concerts</option>
									<option value="4">Gestion des administrateurs</option>
								</select>
								<select name="type">
									<option value="">- Je veux ... -</option>
									<option value="1">Je veux voir une liste compléte</option>
									<option value="2">Je veux modifier la liste</option>
								</select>
								<input type="submit" name="send" value='Gérer' class="small fit primary">
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
