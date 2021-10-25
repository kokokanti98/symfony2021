# symfony2021 version 1.0
## A symfony 5.3.9 web app
### Prérequis:
#### Installer PHP ersion 7.3 ou plus
#### Installer Composer version 2.1 ou plus
#### Installer Symfony 5.3.9 
#### Installer XAMP/ou WAMP avec mariadb-10.4.18 pour mise en place de la base de données sinon les variables de configuration de la bdd se trouve dans /config/services.yaml
#### Configuration de l'url de la base de donées est en server mysql symfony

## Schema de la BDD:
### Voici le lien vers le schéma MCD et MLD de notre base de donéees : https://drive.google.com/drive/folders/1k0u0aiy_E6nX8HcWDzaJkKYXFSfU4Aju?usp=sharing


## Installations:
### Téléchager la dernière version sur le lien(branche exo_form) : https://github.com/kokokanti98/symfony2021/tree/exo_Form
### Lancer les commandes suivantes dans le CMD(invite de commande) dans le répertoire du projet téléchargé:
#### symfony console doctrine:database:create
#### symfony console make:migration
#### symfony console doctrine:migrations:migrate
#### symfony server:start
### Allez sur un navigateur web avec l'adresse du server symfony sur le cmd en vert, généralement c'est le : https://127.0.0.1:8000



### Fonctionnalité:
#### Un exemple de routing un peu avance
#### Création de l'entité User avec ses paramètres
#### Paramétrage du fichier .env des données pour se connecter à la base de donnée(le base de donnée choisi,...)
#### Ajout des 2 entité(Topic, Message) sans les relations
#### Mettre en place les relations entre les entités:
##### 1-De Topic le paramètres author, ManyToOne vers User
##### 2-De Message le paramètres author, ManyToOne vers User
##### 3-De Message le paramètres topic, ManyToOne vers Topic
#### Mis en place des container(variables) qu'on utilisera dans notre .env 
#### Creation de la page de connexion et page d'inscription( make:auth et make:registration)
#### Modification du formulaire d'inscription
#### Mise en place du controller et formulaire de l'entité topic via symfony console:make controller/form
#### Ajout du mode Admin sur les sujets de discussions(topics)
#### Synchronisation des données sur le site web sur les sujets de discussions et affichage détaillé d'un sujet discussions 

#### Ajout du mode Admin sur les utilisateurs(users)
#### Ajout du mode Admin sur les messages
#### Les utilisateurs connécte peuvent envoyer des messages sur le sujet de discussions
#### L'utilisateur saura voir ses messages pour ne pas se perdre dans la discussion grâce à l'auteur nommé "Vous"
#### Mode visiteur qui pourra juste lire les sujets de discussions(avec les sujet de discussions privée)
#### Ajout d'accès aux rôles des utilisateur( seul l'admin peu acéder à tous les pages de gestions des tables dans la bdd)
#### Limitations d'accès des visiteurs(ne peuvent pas voir et accéder aux discussions privée)
#### Création d'un autre formulaire afin de bien différencier la création d'utilisateur(Mode Admin/ Inscriptiion)