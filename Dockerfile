# Используем официальный образ PHP с поддержкой CLI
FROM php:8.0-cli

# Устанавливаем необходимые пакеты для работы с Composer и Git
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Создаем рабочую директорию для вашего проекта
WORKDIR /var/www/html

# Инициализируем новый проект с помощью Composer (создание файла composer.json)
RUN composer init --name="my-php-app" --description="A PHP app with PHPMailer" --require="phpmailer/phpmailer:^6.0" --no-interaction

# Устанавливаем зависимости (в том числе PHPMailer)
RUN composer install

# Копируем все остальные файлы проекта в контейнер (если есть)
COPY . /var/www/html/

# Открываем порт 80 для вашего приложения
EXPOSE 80

# Запуск встроенного PHP-сервера
CMD ["php", "-S", "0.0.0.0:80", "index.php"]
