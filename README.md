# Velo_symfony
Projet vélo en symfony 6
Pour regarder le projet : 

composer install

npm install

php bin/console doctrine:database:create

php bin/console doctrine:migrations:migrate

Pour avoir le role admin :
Editer dans la table user le role_user : ["ROLE_ADMIN"]
