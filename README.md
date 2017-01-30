# Athleteec
##Installation
créer 2 base de données une pour l'application et une pour les tests

1) clone le projet
2) composer install
3) php app/console doctrine:schema:create
4) Ajouter les dossiers suivants au projets

/data_cache/
/web/uploads/posts/

5) php app/console doctrine:fixtures:load

6) 
### Dépendances JS & CSS
Pour commencer installer [**nodeJs**](https://nodejs.org/en/) en global (Executer les commandes avec l'utilisateur par defaut).
Installer gulp et bower.
```
npm install -g gulp
npm install -g bower
```
Puis installer les dépendances à la racine du projet
```
npm install
bower install
```
#### Test:
lancer gulp
```
gulp
```
Les fichiers compilés sont générés dans web/compiled
Il y a deux fichiers js et css pour l'admin et deux autres pour le front contenant les dépendances bowers ainsi que le sass et le js propre au projet.

#### Watchers
Plutôt que de lancer gulp à chaque fois, on peut appeler un watcher pour lancer la compilation à chaque fois qu'un fichier est modifé.
```
gulp watch:sass
gulp watch:js
```

L'application peut-être lancé
