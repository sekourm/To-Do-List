user@user.fr
user

admin@admin.fr
admin

Run the project
===============

<pre>

cd API
composer install
php bin/console database:schema:update
php bin/console server:run

</pre>

Route for API
=============

<pre>

show_categories_path : /show/categories

show_one_categories_path : /show/categories/{categorie_id}

add_categories_path : /add/categories/{name}

update_categories_path : /update/categories/{categorie_id}/{name}

delete_categories_path : /delete/categories/{categorie_id}

show_tasks_path : /show/tasks

show_one_tasks_path : /show/tasks/{tasks_id}

show_one_tasks_by_user_path: /show/tasks/user/{user_id}

add_tasks_path : /add/tasks/{user_id}/{categorie_id}/{title}/{description}/{photo}/{limit_date}

update_tasks_path : /update/tasks/{task_id}/{categorie_id}/{title}/{description}/{photo}/{limit_date}

delete_tasks_path : /delete/tasks/{task_id}

show_profiles_path : /show/profiles

show_one_profiles_path : /show/profiles/{profile_id}

add_profiles_path: /add/profiles/{name}/{lastname}/{password}/{email}/{photo}

active_profiles /active/profiles/{profile_id}

banne_profiles /banne/profiles/{profile_id}

remove_profiles_path : /delete/profiles/{profile_id}

authentificate_profiles_path : /authentification/profiles/{email}/{password}

</pre>