# YiiBoilerplate
We use this folder structure setup on [Clevertech](http://www.clevertech.biz) for our own projects. 

### Overview

**YiiBoilerplate**, aims to provide *Yii developers* an application folder structure with sufficient flexibility to satisfy development needs from simple to enterprise applications.

It may look a little bit too complex at first sight but, at Clevertech, we understand that needs may vary along the development life cycle of a product in order to fulfill customer's requirements and that commonly forces developers to modify the initial folder structure, thus making very hard for a new developer to jump in and 'understand' where everything is located.

In order to avoid such time consuming tasks, **ease the life of our beloved developers** and increase productivity, we make use of this folder structure template for our projects.

### Overall Structure
Below the directory structure we are using:

	/
    backend/
        components/
	config/
            environments/
            	main-private.php *
            	main-prod.php
      			params-private.php *
      			params-prod.php
    	main-env.php *
    	main-local.php *
    	main.php
    	params-env.php *
    	params-local.php *
    	params.php
    	test.php
	controllers/
		SiteController.php
		...
	extensions/
            behaviors/
            validators/
        lib/
        models/
        	FormModel.php
        	...
        modules/
        runtime/ *
        views/
        	layouts/
        	site/
        widgets/
        www/
            assets/ *
            css/
            images/
            js/
            themes/
            index.php
            .htaccess
    common/
        components/
        config/
            environments/
            	params-private.php *
            	params-prod.php
            params-env.php *
            params-local.php *
            params.php
        data/
        extensions/
        	behaviors/
        	validators/
        lib/
            Behat/
            Pear/
            Yii/
            Zend/
        messages/
        models/
        widgets/
    console/
		commands/
		components/
		config/
	    	environments/
		lib/
		migrations/
        models/
        runtime/ *
        yiic.php
    frontend/
		components/
		config/
	    	environments/
	    		main-private.php *
	    		main-prod.php
	    		params-private.php *
	    		params-prod.php
	    	main-env.php *
	    	main-local.php
	    	main.php
	    	params-env.php *
	    	params-local.php *
	    	params.php
	    	test.php
		controllers/
		extensions/
			behaviors/
			validators/
		lib/
		models/	
		modules/	
		runtime/ *
		views/
    		layouts/
    		site/
		www/
	    	assets/ *
	    	css/
	    	files/
	    	images/
            	js/
            	less/
            index.php
            robots.txt
            .htaccess
    tests/
        bootstrap/
            FeatureContext.php
            YiiContext.php
        features/
            Startup.feature
        behat.yml
    
    INSTALL.md
    README.md
    runbehat
    runpostdeploy
    yiic
    yiic.bat

When working in a team development environment, using any of the VCS (Version Control System) available (i.e. Git, SVN), the files and folders marked with an asterisk should **not** be included in the revision system.

###Top Level Directories
At the top-most level, we have:  
  
* ***backend***: the backend application which will be mainly used by site administrators to manage the whole system (avoiding admin modules at frontend application to avoid confusion)   
* ***console***: the console application that is compound of the console commands required for the system.   
* ***frontend***: the frontend application that is the main interface for end users. On a website development, this would be what the site users would see.  
* ***common***: the directory whose content is shared among  all the above applications.
* ***test***: the folder where we include all of our BDD system tests.

The whole application is divided into three applications: backend, fronted and console. Following [the directory structure of the yii project site](http://www.yiiframework.com/wiki/155/the-directory-structure-of-the-yii-project-site), with some twist on its configuration. The common folder is to store all files (extensions, components, behaviors, models, etc… ) that are shared among the mentioned applications.

###Application Directories
The directory structure of each application is very similar. For example **backend** and **frontend** both share the same directory structure with a slight variation at the ***www*** folder of the **frontend** and the inclusion of bootstrap theme and extensions for the **backend**, to easy the task to create Administrative panels.

The shared folder structure is this one:  

* ***components***: contains components (i.e. helpers, application components) that are only used by this application  
* ***config***: contains application specific configuration files.
* ***controllers***: contains controller classes
* ***extensions***: Yii extensions that are only used by this application
* ***lib***: third-party libraries that are only used by this application
* ***models***: contains model classes that are specific for this application
* ***modules***: contains modules that are only used by this application
* ***views***: stores controller actions view scripts
* ***widgets***: stores Yii widgets only used by this application. 
* ***www***: the web root for this application.

We have created **extensions** and **widgets** folders, that could had been obviously included in the **components** folder, in order to clearly differentiate the types of components that could exist into a Yii application and easy the task to find them. So, for example, developers won't search for a widget that renders a jQuery UI plugin within a folder that has application wide components, or helpers, or extensions, or… 

The directory structure for **console** application differs from the others as it doesn't require **controllers**, **views**, **widgets**, and **www**. It has a **commands** directory to store all console command class files.

When developing a large project with a long development cycle, we constantly need to adjust the database structure. For this reason, we also use the DB migration feature to keep track of database changes. We store all DB migrations under the **migrations** directory in **console**.

###The Common Directory
The common directory contains the files that are shared among applications. For example, every application may need to access the database using ActiveRecord. Therefore, we can store the AR model classes under the common directory. Similarly, if some helper or widget classes are used in more than one application, we should also put them under common to avoid duplication of code.

To facilitate the maintenance of code, we organize the common directory in a structure similar to that of an application. For example, we have components, models, lib, etc.


<span style="float:right;">***- source: [Yii Framework Site](http://www.yiiframework.com/wiki/155/the-directory-structure-of-the-yii-project-site#hh3)***</span>
<div style="clear:both">&nbsp;</div>

###Application Configurations
Applications of the same system usually share some common configurations, such as DB connection configuration, application parameters, etc. In order to eliminate duplication of code, we should extract these common configurations and store them in a central place. In our setting, we put them under the config directory in **common**.

####How to configure the application
The configuration for this boilerplate is not that complicated as it seems at first sight. As mentioned before, if our system has both **backend** and **frontend** applications and they both share the same DB configuration. We just need to configure one of the files on the **config** sub-directory under the **common** folder.

The files within the config folder of each application and common folder requires a bit of explanation. When working in a team environment, different developers may have different development environments. These environments are also often different from the production environment. This is why the configuration folders on each application contains a list of files that try to avoid interference among the different environments. 

As you can see, the config folders include a set of files:

* environments/***params-private.php***: This is to have the application parameters required for the developer on its development environment.
* environments/**params-prod.php**: This is to have the application parameters required for the application on **production**
* environments/**main-private.php**: The application configuration settings required for the developer on its development environment.
* environments/**main-prod.php**: The application configuration settings required for the application on **production**
* **main-env.php**: This file will be override with the  environment specific application configuration selected by the **runpostDeploy** script (as we are going to explain after)
* **main-local.php**: This is the application configuration options for the developer*
* **params-env.php**: This will be override with the environment specific parameters selected by the **runpostdeploy** script 
* **params-local.php**: The application parameters for the developer*
* **params.php**: The application parameters
* **test.php**: Test application configuration options


The configuration tree override in the following way:

***local settings > environment specific > main configuration file*** 

That means that local settings override environment specific and its result override main configuration file. And this is true for all configurations folders being the common configuration folder settings predominant over the application specific one:

**common shared params > application params**
**common shared config > application config**

There is a slight difference between the ****-private.php*** and the ****-local.php** files. The first ones are automatically read with the ***runpostdeploy*** script and it could be settings that developers sitting on same machines in internal networks, and the latest is the programmer's configurations. 

The base configuration should be put under version control, like regular source code, so that it can be shared by every developer. The local configuration should **not** be put under version control and should only exist in each developer's working directory.


####The _runpostdeploy_ script
The project has a very useful script that automatically creates the required and **not** shared folders for a Yii application: the **runtime** and **assets** folders, extracts the configuration settings specified for a specific environment and copies them to the ****-env.php*** files and runs migrations when not on private environments -we believe that migrations should be always run manually by developers on their machines.

From the application's root folder, to run the script simply do:

```
./runpostdeploy environmentType migrations
```

* **environmentType** (required): can be "any" of the ones you configure on the **environments** folders (i.e. `./runpostdeploy private` to use ****-private.php*** configurations)
* **migrations** (optional): could be "**migrate**"" or "**no-migrate**". 
	* migrate: will run migrations
	* no-migrate: will not run migrations (on private wont run them anyway)

###YiiBooster library
We have included [YiiBooster](http://yii-booster.clevertech.biz) widget library to the boilerplate. For more information regarding this library and its use
please visit [YiiBooster Site](http://yii-booster.clevertech.biz).

====

> [![Clevertech](http://clevertech.biz/images/slir/w54-h36-c54:36/images/site/index/home/clevertech-logo.png)](http://www.clevertech.biz)    
well-built beautifully designed web applications  
[www.clevertech.biz](http://www.clevertech.biz)
