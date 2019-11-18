#!/bin/bash
git pull origin dev
composer install
bin/console doctrine:schema:update --force
yarn encore production
