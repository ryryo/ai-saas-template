FROM php:8.3-fpm

# 作業ディレクトリを設定
WORKDIR /var/www

# パッケージとPHP拡張機能のインストール
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    nodejs \
    npm

# PHP拡張機能のインストール
RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ユーザーを作成
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# アプリケーションファイルをコピー
COPY . /var/www
COPY .env.example /var/www/.env

# 権限の設定
RUN chown -R www:www /var/www

# ユーザーを切り替え
USER www

# Composerパッケージのインストール
RUN composer install

# npmパッケージのインストール
RUN npm install

# アプリケーションキーの生成
RUN php artisan key:generate

# ポートの公開
EXPOSE 9000

# PHPサーバーの起動
CMD ["php-fpm"] 