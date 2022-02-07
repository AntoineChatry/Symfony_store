# Symfony_store
Symfony store project

Symfony version: 6.0.3

Start:
```
docker compose up -d
symfony console doctrine:migrations:migrate
symfony console doctrine:fixtures:load
symfony serve:start

```


Fix database error:
```
symfony console doctrine:schema:update --force 
```
