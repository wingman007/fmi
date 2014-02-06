ZendSkeletonApplication
=======================

Introduction
------------
This is a simple, skeleton application using the ZF2 MVC layer and module
systems. This application is meant to be used as a starting place for those
looking to get their feet wet with ZF2.


Installation
------------

Using Composer (recommended)
----------------------------
The recommended way to get a working copy of this project is to clone the repository
and use composer to install dependencies:

    cd my/project/dir
    git clone git://github.com/zendframework/ZendSkeletonApplication.git
    cd ZendSkeletonApplication
    php composer.phar install

Using Git submodules
--------------------
Alternatively, you can install using native git submodules:

    git clone git://github.com/zendframework/ZendSkeletonApplication.git --recursive

Virtual Host
------------
Afterwards, set up a virtual host to point to the public/ directory of the
project and you should be ready to go!

Installing Fmi
--------------
Please, use the fmi.sql to import the database. Don't use the Doctrine tool to 
build the DB from the Entities. 

    source <path/to/my/project>/fmi.sql

If you still want to use the Doctrine tool keep in mind:
There are User Entities in 3 modules AuthDoctrine, CsnUser, Fmi.
You have to comment in application.conf.php CsnUser, Fmi modules in order Doctrine tool to work.
Create the DB schema fmi (or wgatever you want) 
and run the tool 

    <path to my project>vendor\bin\doctrine-module.bat orm:schema-tool:create. 

You still have to populate the tables manuly

To Login
-------- 
Use one of the preset accounts:

    username: stoyan

    password: password

Or use the registration to register a new account. Click on ``Login`` from the top menu. 
E-mail confirmation is required.