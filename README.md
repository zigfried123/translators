# Старт проекта
### 1. git clone https://github.com/zigfried123/translators
### 2. Перенести файлы *-local.php в папки /app/frontend, /app/common

## В папке docker выполнить команды:
### 1. docker compose up --build -d
### 2. Войти в контейнер docker exec -it docker-app-1 bash

### 1. composer i
### 2. Создание таблиц rbac php yii migrate --migrationPath=@yii/rbac/migrations
### 3. Додавить пользователей с ролями php yii  add-user

### Изменить права sudo chmod -R 777 /app/frontend/web/assets

## Запустить vue c hot reload
### docker compose up --build
