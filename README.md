# Yii2 Apple Test Task (Yii2 Advanced + Docker)

## Запуск (Docker)
```bash
docker compose up -d --build
docker compose exec php composer install
docker compose exec php php init --env=Development --overwrite=All
docker compose exec php php yii migrate --interactive=0