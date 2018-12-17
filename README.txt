			    Johan Guerrero

#############################################################
										
			   !!! IMPORTANT !!! 				
										
#############################################################
										
	Un compte Admin est prévu dans la base de donnée	
	mail:		admin@admin.fr					
	mdp:		admin							
										
#############################################################

Adresse Web du site + GitHub
	┃
	┣━http://eterniitys.pewpew.space/gestionSite.php
	┃
	┗━https://github.com/Eterniitys/Horizon
	
template
	┃
	┗━https://html5up.net/
		└> https://html5up.net/phantom

Base de donnée d'origine: postgreSQL
	┃	├> SERVEUR	-	localhost
	┃	├> USER	-	postgres
	┃	├> MDP	-	""
	┃	└> DATABASE	-	horizon_TEA
	┃
	┗━Structure
		┃
		┣━table artistes
		┃	├> id_artiste -> pk
		┃	├> image
		┃	├> nom
		┃	└> genre
		┃
		┣━table concert
		┃	├> id_concert -> pk
		┃	├> date_evenement
		┃	├> lieu
		┃	├> place
		┃	├> place_libre
		┃	├> prix
		┃	└> description
		┃
		┣━table emsemble concert
		┃	├> id_concert -> fk
		┃	└> id_artiste -> fk 
		┃		╙─> pk (id_concert, id_artiste)
		┃		
		┣table utilisateurs
		┃	├> id_utilisateur -> pk
		┃	├> nom
		┃	├> prenom
		┃	├> mail
		┃	└> mdp
		┃
		┣table administrateurs
		┃	├> id_admin -> pk
		┃	└> id_utilisateur -> fk		
		┃	
		┣table commande
		┃	├> id_commande -> pk
		┃	├> id_utilisateur
		┃	└> date_commande
		┃
		┗table ligne_commande
			├> id_ligne -> pk
			├> id_commande
			├> id_concert
			└> nbplace
			
- - - - - - - - - - - - - - - - - - sprint_4 - - -

fichiers ajoutés:
	└> vue_api.php
		# il est nécéssaire de rentré la page a la main dans l'omnibox
		# ne fonctionne que si vous étes connecté en administrateur

fichiers modifiés:
	└> None

fichiers supprimés:
	└> None
		
- - - - - - - - - - - - - - - - - - sprint_3 - - -

fichiers ajoutés:
	├> # Fichier ajoutant des fonctions utile
	│	└> utils.php
	├> # Ajout de la classe concert, n'est pas implémentée de maniére systématique sur les pages réalisées précédement (TODO)
	│	├> app/
	│	└> concert.php
	└> # Fichier lié à la commande/panier
		├> commander.php
		└> panier.php

fichiers modifiés:
	├> sessionFin.php
	├> gestionSite.php
	├> sql/table.sql
	└> lisez-moi-jguerrer.txt
		└>README.txt

fichiers supprimés:
	├> # Ajout des fonctions du Panier
	│	├> vue-concert.php
	│	├> vue-artiste.php
	│	└> vue-concert.php 
	├> connexion_mysql.php
	└> init.php
	
- - - - - - - - - - - - - - - - - - sprint_2 - - -

fichiers ajoutés:
	├> # Fichier lié a la lecture des données
	│	└> vue.php
	├> # Fichier d'inclusion placé en tête et fin de fichier
	│	├> init.php
	│	└> footer.php
	├> # Fichier lié à la session/connexion
	│	├> inscription.php
	│	├> sessionFin.php
	│	└> accesCompte.php
	├> # Fichier lié à la gestion du site en tant qu'administrateur
	│	├> gestionSite.php
	│	└> traitement.php
	└> images_backup.zip

	
fichiers modifiés:
	├> sql/table.sql
	└> lisez-moi-jguerrer.txt

- - - - - - - - - - - - - - - - - - sprint_1 - - -

fichiers ajoutés:
	├> connexion_mysql.php
	├> connexion_postgres.php
	├> header.php
	├> images/*
	├> images/artistes/*
	├> images/banner/*
	├> sql/*
	├> favicon.ico 
	├> vue-artiste.php
	├> vue-concert.php
	└> lisez-moi-jguerrer.txt
	
fichiers modifiés:
	├> index.html
	│	└> index.php
	└> generic.html
		├> vue-artiste.php
		└> vue-concert.php
