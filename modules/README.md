# Modules quick guide.

This folder contains core and 3rd party modules for application.

## Module structure.

The folder structure of module must match the MVC pattern.

moduleName
|- db
|- model
|- view
|- controller
|- Install.php
|- README.md

### Install.php - common module file.

Each Install.php file must implement Includes\ModuleInstall interface.

When lifecontrol-server application started then it scan modules folder and do some actions:

* Register module namespaces.
* Checking module installation and if it not installed then executing ModuleName\Install::register() for start installations process.
* Executing static method ModuleName\Install::routes() for adding module routes.

### db folder

This folder must contains database entities for Phalcon ORM.
