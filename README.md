# NoticeBoardsBundle (RecipeBundle)

Created by Justin Clarke
Date 09-02-2016

This is being re-written in Python and Django, to both learn a new language and system, and for fun.
[Django-Recieps](https://github.com/JustinAClarke/django_recipes)

### Instaling

This requires Symfony 6.x

 * Install Symfony and create a base 'project'
 * Clone this repo into /src/ as NoticeBoardBundle `/src/NoticeBoardBundle`
 * Place the below into the config files:
 
 ```
 config/routes.yaml
    ...
controllers:
    resource: ../src/NoticeBoardBundle/Resources/config/routing.yml
    type: yaml
    ...

config/bundles.php
    ...
    use App\NoticeBoardBundle as NoticeBoardBundle;
return [
    NoticeBoardBundle\NoticeBoardBundle::class => ['all' => true],
];
    ...
config/packages/twig.yaml
twig:
    default_path: '%kernel.project_dir%/templates'
    paths:
        '%kernel.project_dir%/src/NoticeBoardBundle/Resources/views': 'NoticeBoardBundle'

 ```
 install composer requires:
 ```
    symfony require symfony/twig-bundle
    symfony composer require symfony/orm-pack
    symfony composer require symfony/asset
    symfony local:check:requirements
    symfony local:check:requirements
    symfony local:check:requirements
    symfony composer require symfony/form
    symfony composer require symfony/translation

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
If there are issues, please submit them to the [issue tracker](https://github.com/JustinAClarke/RecipeBundle/issues)
and I will take a look and either fix it in this, or move it to the django project and fix it in there.

