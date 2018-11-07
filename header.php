<!-- Header -->
	<header id="header">
		<div class="inner">

			<!-- Logo -->
				<a href="index.php" class="logo">
				<?php if($_SESSION[id_utilisateur] >= 0):?>
					<span class="symbol"><img src="images/logo.png" alt="" /></span><span class="title">Horizon - <?= $_SESSION[nom]?> <?= $_SESSION[prenom]?></span>
				<?php else :?>
					<span class="symbol"><img src="images/logo.png" alt="" /></span><span class="title">Horizon</span>
				<?php endif ;?>
				</a>

			<!-- Nav -->
				<nav>
					<ul>
						<li><a href="#menu">Menu</a></li>
					</ul>
				</nav>

		</div>
	</header>

<!-- Menu -->
	<nav id="menu">
		<?php if(isset($_SESSION[admin]) && $_SESSION[admin] == true):?>
		<h2>Menu - Admin</h2>
		<?php else :?>
		<h2>Menu</h2>
		<?php endif ;?>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="vue.php?artistes">Tous les artistes</a></li>
			<li><a href="vue.php?concerts">Tous les concerts</a></li>
			<li><a href="#">Mon Panier</a></li>
			<?php if($_SESSION[id_utilisateur] >= 0):?>
				<!--Liens utilisateur connecté -->
				<li><a href="sessionFin.php">Deconnexion</a></li>
				<?php if(isset($_SESSION[admin]) && $_SESSION[admin] == true):?>
				<!--Liens Administrateurs -->
				<li><a href="gestionSite.php">Administration du Site</a></li>
				<li><a href="elements.php">Elements</a></li>
				<?php endif ;?>
			<?php else :?>
				<!--Liens hors connexion -->
				<li><a href="accesCompte.php">Connexion</a></li>
			<?php endif ;?>
			<!--li><a href="vue-artiste.php">Tempus etiam</a></li>
			<li><a href="vue-artiste.php">Consequat dolor</a></li-->
			
		</ul>
	</nav>
