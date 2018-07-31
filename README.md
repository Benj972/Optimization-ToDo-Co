ToDoList
========

This repository is the project 8 "ToDoList" in course Php Symfony Web Developer with [OpenClassrooms](https://openclassrooms.com/projects/ameliorer-un-projet-existant-1).

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/0c3af8d0b23c4961a8ec290a51e81f3e)](https://www.codacy.com/app/Benj972/ToDo-Co?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Benj972/ToDo-Co&amp;utm_campaign=Badge_Grade)

Context:
--------
ToDoList is an application to manage your daily tasks. This web application is Minimum Viable Product at the beginning.
We need to improve the quality of the application. We need to implement new features, correct the anomalies and implement automated tests.
Finally, we analyze the quality of the code and the performance axes.

Prerequisites:
--------------
* Local server environment
* PHP v7.0
* MySQL
* Composer

Dependencies:
-------------
The most important in this project:
* [PhpUnit Bridge](https://github.com/symfony/phpunit-bridge)
* [DoctrineFixturesBundle](https://github.com/doctrine/DoctrineFixturesBundle)
* [DoctrineBundle](https://github.com/doctrine/DoctrineBundle)
* [TwigBundle](https://github.com/symfony/twig-bundle)
* [Security-bundle](https://github.com/symfony/security-bundle)

Those dependencies are included in composer.json.

Installation:
-------------
1. To be placed in the folder
2. Recover Repository: `git clone https://github.com/Benj972/ToDo-Co.git`
3. Install Composer: `php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"`and`composer-setup.php`
4. Install Library : `php composer.phar install`
5. Configuring the [Database](https://symfony.com/doc/current/doctrine.html)
6. Create database: `php bin/console doctrine:database:create`
7. Update database: `php bin/console doctrine:schema:update --force`
8. Load database: `php bin/console doctrine:fixtures:load`

Testing:
--------
* Create test database `php bin/console doctrine:database:create --env=test`
* Update database: `php bin/console doctrine:schema:update --force --env=test`
* Load database: `php bin/console doctrine:fixtures:load --env=test`
* Run the tests with `vendor/bin/simple-phpunit`
* If you want to see the HTML code coverage run this command `vendor/bin/simple-phpunit --coverage-html cov/`

Quality and Performances:
-------------------------
You check code quality on each pull request with [Codacy](https://www.codacy.com/) and with tests in continuous integration [Travis CI](https://travis-ci.org/).

Application performances were analyzed with [BlackFire](https://blackfire.io/) tool.

Documentation:
--------------
In `/docs` folder you can find:
* An explanatory [document](https://github.com/Benj972/ToDo-Co/blob/feature/refactoring/docs/L'authentification.pdf) on authentication
* The code quality and performance [audit report](https://github.com/Benj972/ToDo-Co/blob/feature/refactoring/docs/Audit%20de%20qualit%C3%A9.pdf)
* [Instructions to contribute](https://github.com/Benj972/ToDo-Co/blob/feature/refactoring/docs/contribution.md) to the project
* [UML diagrams](https://github.com/Benj972/ToDo-Co/tree/feature/refactoring/docs/diagrams)