# syntax=docker/dockerfile:1.2

FROM webdevops/php-nginx:8.1-alpine

# MacOS M1 fix
# RUN wget -O "/usr/local/bin/go-replace" "https://github.com/webdevops/goreplace/releases/download/1.1.2/gr-arm64-linux"
# RUN chmod +x "/usr/local/bin/go-replace"
# RUN "/usr/local/bin/go-replace" --version

# Install PHP extensions
RUN apk add mysql mysql-client oniguruma-dev mysql-dev libxml2-dev

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy entrypoint
COPY entrypoint.d/entrypoint.sh /opt/docker/provision/entrypoint.d/entrypoint.sh

# Set web root
ENV WEB_DOCUMENT_ROOT /app/public

# Set working directory
WORKDIR /app

# Copy project files
COPY . .
