drop table if exists ensemble_groupe;
drop table if exists concerts;
drop table if exists artistes;
drop table if exists administrateurs;
drop table if exists utilisateurs;

drop domain if exists adresseMail;

CREATE DOMAIN adresseMail
	AS varchar(50) check (value ~ '^([\w]+\.)*([\w]+)@([\w]+)(\.(com|fr|gf|pf|info))$');
	
CREATE TABLE artistes (
    id_artiste serial NOT NULL PRIMARY KEY,
    image varchar(60),
    nom varchar(30),
    genre varchar(30)
);

CREATE TABLE concerts (
    id_concert serial NOT NULL PRIMARY KEY,
    date_evenement date NOT NULL,
    lieu varchar(50) NOT NULL,
    place integer NOT NULL,
    place_libre integer CHECK (place_libre <= place) DEFAULT 0,
    prix numeric(5,2) DEFAULT 100 NOT NULL,
    description text
);

CREATE TABLE ensemble_groupe (
    id_concert integer NOT NULL REFERENCES concerts on delete cascade,
    id_artiste integer NOT NULL REFERENCES artistes on delete cascade,
	PRIMARY KEY (id_concert, id_artiste)
);

CREATE TABLE utilisateurs (
    id_utilisateur serial NOT NULL PRIMARY KEY,
    nom varchar(30) NOT NULL,
    prenom varchar(30) NOT NULL,
    mail adresseMail UNIQUE,
    mdp char(40) DEFAULT 100 NOT NULL
);

CREATE TABLE administrateurs (
    id_admin serial PRIMARY KEY,
    id_utilisateur integer NOT NULL unique REFERENCES utilisateurs
);

CREATE TABLE commande (
    id_commande serial PRIMARY KEY,
    id_utilisateur integer NOT NULL REFERENCES utilisateurs,
	date_commande date default CURRENT_DATE
);

CREATE TABLE ligne_commande (
	id_ligne serial PRIMARY KEY,
    id_commande integer NOT NULL REFERENCES commande,
	id_concerts integer not null REFERENCES concerts,
	nbPlace integer not null
);

--- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- 

insert into artistes (image, nom, genre) values
	('ArticEmpire.jpg', 'Artic Empire','Mix'),
	('Ed_Sheeran.jpg', 'Ed Sheeran','Pop'),
	('Eklipse.jpg', 'Eklipse','Pop/Rock'),
	('Garou.jpg', 'Garou','Pop'),
	('Rodrigo_Gabriela.jpg', 'Rodrigo y Gabriela','Flamenco'),
	('Tal.jpg', 'Tal','Pop'),
	('AC_DC.jpg', 'AC-DC','Rock');

insert into concerts (date_evenement, lieu, place, place_libre, prix, description) values
	('2018-12-24', 'Paris La Défense Arena',40000,	40000,	150.00,	'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque aliquet lorem et sapien mattis, et tempor purus rutrum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia.'),
	('2018-10-27', 'Amphithéâtre extérieur du Zénith de Nancy',25000, 25000, 130.00,' Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas quis porttitor urna. Vestibulum facilisis erat et quam porttitor fringilla. Integer eget sapien vitae elit tincidunt aliquam.'),
	('2019-03-26', 'AccorHotels Aréna (POPB)',20300, 20300,	99.99, 'Nunc eu lectus ut arcu gravida vestibulum sit amet ut metus. Sed vel finibus urna. Donec est lacus, elementum non odio vitae, suscipit aliquet metus. Integer vehicula placerat dolor eget.'),
	('2019-09-25', 'Halle Tony Garnier', 17000, 17000, 113.00, 'Nunc nunc lectus, scelerisque ac nisl sed, maximus vestibulum tellus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec vestibulum tempus hendrerit. Vivamus elementum purus ac aliquam consectetur.'),
	('2019-01-03', 'Sud de France Arena', 14800, 14800, 50.00, 'Sed malesuada arcu eget turpis iaculis imperdiet. Donec quis libero libero. Integer sit amet turpis malesuada, egestas purus vel, efficitur nisl. Etiam ultricies odio nec tristique scelerisque. Vestibulum eget posuere.'),
	('2019-05-30', 'Arena stade couvert de Liévin',14000, 14000, 50.00, 'Nulla venenatis sagittis sagittis. Vestibulum eget laoreet nunc, vitae fermentum est. Praesent tincidunt elementum dolor accumsan hendrerit. Vivamus justo arcu, porta in turpis a, varius tristique libero. Integer tristique quam.'),
	('2019-02-24' ,'Arènes de Béziers', 13100, 13100, 50.00, 'Sed dapibus felis a ante blandit maximus. Curabitur tristique felis a tellus venenatis, et mollis risus imperdiet. Suspendisse orci magna, auctor at turpis vitae, semper blandit elit. Aliquam molestie purus.'),
	('2019-01-10', 'Gayant Expo', 13000, 13000, 79.95, 'Duis a ullamcorper nunc. Quisque non commodo velit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer condimentum nulla ultricies dolor blandit pellentesque. Sed nec ex diam. Duis imperdiet finibus.'),
	('2018-11-27', 'Arènes de Nîmes', 13000, 13000, 64.00, 'Aliquam erat volutpat. Sed ultrices iaculis tortor eget tempor. Curabitur convallis quis lectus id feugiat. Maecenas sem lorem, porta efficitur suscipit ut, lacinia ut ligula. Maecenas non nisl in dolor.'),
	('2018-11-22' ,E'Arènes d\'Arles', 12500, 12500, 49.99, 'Mauris ornare, enim fringilla maximus dapibus, est ipsum mollis felis, id ultricies massa nunc id libero. Vestibulum est erat, fermentum ut luctus at, feugiat non enim. Morbi porta purus nec.'),
	('2019-02-04', 'Galaxie', 12200, 12200, 50.00,'Aliquam posuere, tortor a euismod ultricies, risus dui mollis lectus, ac imperdiet justo nunc et ante. Ut suscipit mauris quam, in pellentesque dui dignissim convallis. Etiam enim diam, blandit varius.'),
	('2018-12-28', 'Zénith Strasbourg Europe', 12079, 12079, 40.00, 'Pellentesque sit amet finibus justo. Vestibulum vel vehicula quam. Ut sit amet vehicula urna, et ullamcorper justo. Nulla pretium dapibus neque non gravida. Phasellus ornare venenatis lorem, eu dictum urna.');

insert into ensemble_groupe (id_concert, id_artiste) values 
	(1, 1),(1, 2),(1, 3),(1, 4),(1, 5),(1, 6),(1, 7),
	(2, 2),(2, 6),
	(3, 4),(3, 5),
	(4, 1),
	(5, 1),
	(6, 2),(6, 4),
	(7, 7),
	(8, 1),
	(9, 1),
	(10, 7),
	(11, 1),
	(12, 7);
	
insert into utilisateurs(nom,prenom,mail,mdp) values ('Guerrero', 'Johan', 'johan.guerrero394@gmail.com','6bef1da66989960533e9f1a8e34560703ff2d245'),
		('Diez', 'Marie', 'spel7900@gmail.com','03faefdfdcb86a6ca64fbd0d0f5c1d804dfd6bc4');
		
insert into administrateurs(id_utilisateur) values
	(1),
	(2);