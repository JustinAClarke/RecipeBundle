TODO LIST: (WITH NOTES)

Create Blood Type Food list, with option to only show specific blood types, and search for foods:
if search returns nothing for specific categories, hide that category, and if search returns no foods at all, show "Sorry Nothing Found"

Show with both Title ad colour if foods are alright or not.

Code for hiding or showing objects: might need to change it slightly.
$(".hidden").each(function(){
  $(this).removeClass( "hidden" );
});


create external php file, and use in controller.php

create and use localisation file, so you can specify field names/titles

Create Default site name "My Recipes"

Create admin path, with below abilities:
    Add / remove users, (permssions)
    
    Change Site Name, bg image, theme
    
    Backup and restore recipes,
    
    Export recipes.
    
    Allow sharing of reciepes?
    
    restoring deleted recipes.

Allow soft delete, (restore)

Allow create and delete of categories (rename).
Display count of recipes, for each cat.
With delete, if contains recipes, give option to delete, or move to new category


Change DB schema
Recipes:
id, cat_id, title, ing, meth, note, creator, date, date-mod, serves, ptime, ctime, deleted, shareable?

Cat:
id, title, deleted. 
