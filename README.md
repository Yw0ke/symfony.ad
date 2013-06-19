# **Symphony.ad** #

**Getting started:**

*I : Récuperer le projet.*

1.	Se rendre dans votre espace de travail (exemple c:/wamp/git/).
2.	Cloner le projet grâce à cette commande : `git clone https://github.com/Yw0ke/symfony.ad.git`
3.	Créer un virtualhost dans votre httpd-conf.
4.	Mettre à jour le fichier host (C:\Windows\System32\drivers\etc\hosts) en rajoutant cette ligne : 
    `127.0.0.1	symfony.ad`
5.	Redémarrer apache.

*II : Configurer la base de données du projet.*

1.	Se rendre dans le dossier de configuration de l’application (c:/wamp/git/symfony.ad/symfony.ad/app/config).
2.	Renommer parameters.yml.bckp en parameters.yml.
3.	Editer ce fichier et configurer votre BDD (indiquer au moins votre mot de passe).


*III : Installer les dépendances.*


1.	Se rendre dans le dossier de l’application c:/wamp/git/symfony.ad/symfony.ad/.
2.	Utiliser cette commande : `php composer install`

*IV : Effectuer les migrations et intégrer les fixtures.*

1.	Créer une base de données `symfony.ad` grâce a phpmyadmin.
2.	Se rendre dans le dossier de l'application c:/wamp/git/symfony.ad/symfony.ad/.
3.	Utiliser cette commande : `app/console doctrine:migrations:migrate`. (si erreur, effacer le contenu de `symfony.ad` et relancer la commande.
4.	Ainsi que celle-ci : `app/console doctrine:fixtures:load`.


*V : Accéder à l’application.*

1. Simplement taper symfony.ad dans la barre d’adresse pour accéder à la page d’accueil.
2. Les utilisateurs déjà enregistrer sont superadmin et user. (même password que les login)


*Exemple de virtualhost à placer à la fin du httpd-conf : 


    #####
    ## symfony.ad 
    ## DOMAINE de symfony.ad  
    #####
    NameVirtualHost symfony.ad
    
    <VirtualHost symfony.ad>
    DocumentRoot C:/wamp/git/symfony.ad/symfony.ad/web
    ServerName symfony.ad
    <Directory "C:/wamp/git/symfony.ad/symfony.ad/web">
    DirectoryIndex app_dev.php
    AllowOverride All
    Allow from All
    </Directory>
    </VirtualHost>
