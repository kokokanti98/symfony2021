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