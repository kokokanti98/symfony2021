# symfony2021 routing banch
## A symfony 5.3.9 web app
### Prérequis:
#### Installer PHP ersion 7.3 ou plus
#### Installer Composer version 2.1 ou plus
#### Installer Symfony 5.3.9 

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
#### Synchronisation des données sur le site web sur les sujets de discussions et affichage détaillé d'un sujet discussion 

#### Ajout du mode Admin sur les utilisateurs(users)
