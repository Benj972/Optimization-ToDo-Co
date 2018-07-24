Contributions to ToDoList
=========================

Context:
--------
ToDoList is a collaborative project on which many people can work together. It is important to follow a certain procedure to contribute to this project.

Requirement:
------------
* A [github](https://github.com/) account
* [Git-flow](https://danielkummer.github.io/git-flow-cheatsheet/index.fr_FR.html)
* [PhpUnit Bridge](https://symfony.com/doc/current/components/phpunit_bridge.html)
* A [Travis CI](https://travis-ci.org/) account
* A [Codacy](https://www.codacy.com/) account

Instructions:
-------------
1. [Fork the repository](https://help.github.com/articles/fork-a-repo/) on Github
	A fork is a copy of a repository. The forks are used to propose modifications on the project.
	On GitHub, navigate to the [Benj972/ToDo-Co](https://github.com/Benj972/ToDo-Co) repository.
	In the top-right corner of the page, click Fork.

2. Clone your Fork
	Let's create a clone of your fork locally on your computer.
	In your Fork, click `Clone or download` and copy the clone URL.
	To be placed in a folder in Git and enter `git clone https://github.com/Benj972/ToDo-Co.git`

3. Install Project
	Refer to [README.md](https://github.com/Benj972/ToDo-Co/blob/master/README.md) to install application.

4. Contribute to apllication
	Use git-flow for contribute to project. You work from the develop branch and you create a new branch to make a change.
	You create a feature for develop, `git flow feature start MYFEATURE`.

5. Create a Pull Request
	Push your work and branch to your fork on GitHub by running this command: `git flow feature publish MYFEATURE`.
	Go to your fork on your GitHub account to open a pull request. 
	A Pull Request allows you to discuss and review potential changes with collaborators and add tracking validations before your changes are merged into the base branch.

6. The rules to be respected
	During your work, please respect:
	* [PHP Standards Recommendations (PSR)](https://www.php-fig.org/psr/)
	* [Symfony Coding Standard](https://symfony.com/doc/current/contributing/code/standards.html)
	* [Symfony Best Practices](https://symfony.com/doc/current/best_practices/index.html)
	You can use [PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) to help you.

7. Tests and Quality of code
 	* Code coverage with PhpUnit Bridge
 		It is important to test each new feature to maintain a code coverage of over 90%.
 		For check code coverage run this command `vendor/bin/simple-phpunit --coverage-html cov/`

 	* Continuous integration
		For each pull request, Travis CI will automatically run tests and code will be checked by the Codacy tool.	
		It must be ok before you merge branch.