
# Drupal Cat Widget Project

This repository contains a Drupal project configured to use `ddev` for local development. Follow the instructions below to clone, set up, and run the project on your local environment.

## Requirements

- [Composer](https://getcomposer.org/) installed on your machine
- [ddev](https://ddev.readthedocs.io/en/stable/#installation) installed on your machine

## Setup Instructions

### 1. Install Composer Dependencies

After cloning the repository, install the project's PHP dependencies using Composer:

```bash
composer install
```

This command installs all necessary dependencies defined in the `composer.json` file.

### 2. Start ddev

Initialize and start the `ddev` environment:

```bash
ddev start
```

This will create the containers and start the local development environment. Once started, ddev will provide a local URL where the site can be accessed (usually `http://<project-name>.ddev.site`).

### 3. Import the Database

If a database dump is provided, you can import it using `ddev`:

```bash
ddev import-db --src=backups_db/latest.sql
```

This will restore the database from the provided SQL dump.

### 4. Import Configuration

Import the site's configuration to ensure that the system is set up with the correct modules, settings, and configurations:

```bash
ddev drush cim -y
```

This command will import the configuration from the `config/sync/` directory, setting up the site according to the exported configuration.

### 5. Access the Site

Once the environment is set up, you can access the site through the URL provided by `ddev`, typically:

```
http://drupal-cat-project.ddev.site:8080/
```
- **Command to Launch the Site**
```
ddev launch
```

### 6. Additional Commands

- **Stop the environment:**
  ```bash
  ddev stop
  ```

- **Rebuild the environment (if needed):**
  ```bash
  ddev restart
  ```

---

## Additional Information

- **Configuration Management**: All configuration is stored in the `config/sync/` directory. This allows easy export and import of configuration changes using Drush.
- **Database Backups**: Any database dumps should be stored in the `backups_db/` directory for easy reference and restoration.
