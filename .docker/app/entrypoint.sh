#!/bin/bash

composer install
# Running Vue.js development build in background.
npm run watch --prefix ./front &

# Running Vue.js dashboard in background. (NEED EXPOSE PORT 8000 in 'docker-compose' file)
#vue ui --host 0.0.0.0 &

php-fpm
