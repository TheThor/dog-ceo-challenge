## Setup requirements
- Docker
- Lando (check requirements [here](https://docs.lando.dev/getting-started/installation.html))

## Steps to build/run
- lando start
- lando composer install
- lando drush sql-cli < db-backup/database-backup.sql
- tar -xf images.tar -C web/sites/default/files
