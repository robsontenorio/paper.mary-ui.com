# Base
FROM robsontenorio/laravel:sideup AS base
COPY --chown=www-data:www-data . .

# Build
FROM base AS build
RUN cp .env.example .env
RUN composer install --prefer-dist --no-interaction --no-progress --ansi
RUN yarn install && yarn build

# Production
FROM build AS production
ENV RUN_DEPLOY=true

