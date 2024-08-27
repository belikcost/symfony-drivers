## Требования

- Docker и Docker Compose

## Установка и запуск

### 1. Настроить окружение
Создайте файл .env в корне проекта, если он еще не создан:
```bash
cp .env.example .env
```

### 2. Запустить Docker-контейнеры
Соберите и запустите контейнеры с помощью Docker Compose:
```bash
docker-compose up -d --build
```

### 3. Накатить миграций БД
После того как контейнеры запущены:
```bash
docker-compose exec app php bin/console doctrine:migrations:migrate
```

#### По дефолту приложение запускается на http://localhost:80