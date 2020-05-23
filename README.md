# Momoprix e-commerce

Requirements on your computer:
- Composer
- Symfony
- Php

How to setup the project:
- 1 - git clone the repository
- 2 - Open in visual studio code
- 3 - run this command to install all the packages : 'composer install'
- 4 - Delete all migrations files in the version folder, then run the following command: php bin/console make:migration
- 5 - run : php bin/console doctrine:migration:migrate
- 6 - you can now start the webserver with : symfony server:start
