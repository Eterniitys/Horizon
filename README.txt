Johan Guerrero

#############################################################
#								#
#			   !!! IMPORTANT !!! 			#
#								#
#############################################################
#								#
#	Un compte Admin est harcodé dans la base de donnée	#
#	mail:		admin@admin.fr				#
#	mdp:		admin					#
#								#
#############################################################

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
		┗table administrateurs
			├> id_admin -> pk
			└> id_utilisateur -> fk

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
	├> connexion_mysql
	├> connexion_postgres
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
