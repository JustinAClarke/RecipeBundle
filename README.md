# NoticeBoardsBundle (RecipeBundle) (ARCIVED)

Created by Justin Fuhrmeister-Clarke
Date 09-02-2016

## ARCHIVE
This is being re-written in Python and Django, to both learn a new language and system, and for fun.
[Django-Recieps](https://github.com/JustinFuhrmeister-Clarke/django_recipes)

### Instaling

This requires Symfony 3.x (though it may work with symfony 4.x, I havent tested it)

 * Install Symfony and create a base 'project'
 * Clone this repo into /src/ as NoticeBoardBundle `/src/NoticeBoardBundle`
 * Place the below into the config files:
 
 ```
 config/routing.yml
    ...
notice_board:
    resource: "@NoticeBoardBundle/Resources/config/routing.yml"
    prefix:   /
    ...

AppKernel.php
    ...
        new NoticeBoardBundle\NoticeBoardBundle(),
    ...

 ```
 * Update the database with the schema from this bundle
 
 ```
 php bin/console doctrine:schema:update --dump-sql
 php bin/console doctrine:schema:update --force
 
 ```
 
 * Install the assets
 `php bin/console assets:install`
 
 * Run the project
 
 
### ISSUES
If there are issues, please submit them to the [issue tracker](https://github.com/JustinFuhrmeister-Clarke/RecipeBundle/issues)
and I will take a look and either fix it in this, or move it to the django project and fix it in there.

