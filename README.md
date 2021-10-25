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
#### Création du projet symfony adpaté web app avec la commande: symfony new --full symfony2021 
