DzProjectModule
=========

Module de gestion de projets pour ZF2, compatible Doctrine.

Installation
==========

composer
----------

Télécharger [composer](https://getcomposer.org/).
Ajouter le module *dieze/dz-project-module* au composer.json :
	
	cd path/to/application
	php composer.phar require dieze/dz-project-module
	
Choisir la version "~1".

assets
----------
Créer un lien symbolique *dzproject* dans votre dossier *public/* qui pointe vers le dossier *public/* du module :

	cd path/to/application/public
	ln -s path/to/dz-project-module/public dzproject

base de données
-------------
Créer les tables dans votre base de données sqlite nécessaires au fonctionnement du module :

	sqlite3 path/to/database.sqlite < path/to/dz-project-module/data/dzproject.sqlite.sql

Documentation
================
Une fois le module installé et activé, se rendre à /project pour accèder à la documentation complète du module.