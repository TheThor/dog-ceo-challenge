# What is this?
This repo was created to show the work done on the context of an interview challenge for devoteam.

The idea is to have a small project, where a few back-end exercises are done, to create a small app that contains a View, an API endpoint with a random image and some custom configuration in the admin.

The view was done using the UI, the API endpoint was done using a Drupal Restful module and the block, service and admin options are all custom modules.

## Setup requirements
- Docker
- Lando (check requirements [here](https://docs.lando.dev/getting-started/installation.html))

## Steps to build/run
- lando start
- lando composer install
- lando drush sql-cli < db-backup/database-backup.sql
- tar -xf images.tar -C web/sites/default/files
- lando drush cim (Optional, in case something is updated beyond the initial DB)
- lando drush uli (optional, to jump into admin)
