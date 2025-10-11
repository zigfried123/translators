# Старт проекта
### 1. git clone https://github.com/zigfried123/translators
### 2. Перенести файлы *-local.php в папки /app/frontend, /app/common, /app/backend

## В папке docker выполнить команды:
### 1. docker compose up --build -d
### 2. Войти в контейнер docker exec -it docker-app-1 bash
### 3. composer i

### Изменить права sudo chmod -R 777 /app/frontend/web/assets

## Запустить vue c hot reload
### docker compose up --build
