# Webpals - Gutenberg Blocks Collection   
A standardized, organized, object-oriented foundation for building high-quality WordPress Gutenberg Blocks.
- - - -


## Dependencies

The following dependencies must be installed on your environment, prior to the plugin installation process.

1. [PHP 7.4](https://www.php.net/releases/7_4_0.php)
2. [GIT](https://git-scm.com/)
3. [Composer](https://getcomposer.org/) 
4. [Node](https://nodejs.org/en/download/)
5. [Npm](https://www.npmjs.com/)


## Features

This Plugin code was built on top of The [Webpals WordPress Plugin Boilerplate](https://bitbucket.org/webpals/wordpress-plugin-boilerplate/).   

The current version altered some of the original implementation and utilize new features such as:   

* 	PHP Basic coding standards of
	[PSR-1](https://www.php-fig.org/psr/psr-1/),
	[PSR-12](https://www.php-fig.org/psr/psr-12/)
* 	PHP class auto-loading using the [PSR-4](https://www.php-fig.org/psr/psr-4/) code standard.
* 	WordPress coding standards of [Plugin API](http://codex.wordpress.org/Plugin_API), [Code](http://codex.wordpress.org/WordPress_Coding_Standards) and [Documentation](https://make.wordpress.org/core/handbook/best-practices/inline-documentation-standards/php/) standards.
* Environment variables implemented with [PHP dotenv](https://github.com/vlucas/phpdotenv) and [dotenv-expand](https://github.com/motdotla/dotenv-expand).
* Dependency Injection using [PHP DI](http://php-di.org/) and [PSR-11](https://www.php-fig.org/psr/psr-11/) DI Container standard.
* [Webpack](https://webpack.js.org/)
* [EsLint](https://eslint.org/)
* [SCSS](https://sass-lang.com/)
* [React](https://reactjs.org/)


### 
## Plugin Installation
- - - -

Clone this repository into your WordPress `plugins` directory.   


#### Setting the environment  

The environment variables are defined on the `.env` file, which is located under the plugin _root_ directory.   

Clone the `.env.example` file and name it `.env`( this should be under the plugin _root_ directory as the original file location). 

Update the file variables according to you desired configuration, read more in _docs_ - [Environment variables](docs/environment.md).


#### Installing Dependencies   

Run the following commands from the plugin `root` directory.

* `composer install`

* `npm install`


#### Building Assets

Run the command from the plugin `root` directory.

* Build with watch mode => `npm run start`

* Build Once => `npm run build`

In the case you get a message _Build process exited, since no blocks config were found..._   
then skip this step and run either of these commands, once you have an existing block under the `./blocks` directory.   
See _docs_ - [How to create a dynamic block](docs/creating-and-registering-dynamic-block.md)

It's safe to activate the plugin at this point :)



## Blocks Module
- - - -

Dedicated for all Gutenberg Blocks functionality of the site, can be found in the  `./blocks/` directory.

#### _BootstrapBlocks_ `Blocks\BootstrapBlocks`
This class is responsible for registering all existing _blocks_ under the  `./blocks/` directory.
	
	
#### _AbstractBlock_ `Blocks\AbstractBlock`
This class is the foundation for creating Dynamic Gutenberg block , It is responsible for all the heavy lifting functionality when creating and registering a dynamic block.
So creating a given block becomes a fast easy process.    
 
#### _Block_ `\Blocks\*\Block`
This class is a _block_ instance that extends `Blocks\AbstractBlock`, each _block_ has its own dedicated directory, The '*' represents the unique _namespace_ of each block.

See in _docs_ - [Creating a dynamic block](docs/creating-and-registering-dynamic-block.md).


## Common Modules  
- - - -
`WgBlocks\Common\*` are dedicated for the common\core functionality of the plugin, can be found in the `./common/` directory.   

See in _docs_ - [Common modules list and definitions](docs/common-modules-list.md).


### 
## Additional Docs
- - - -

All Modules (classes), functions, and variables are documented so that you know what you need to change.   

The Plugin uses a strict file organization scheme and that makes it easy to organize the files that compose the plugin.

### Blocks

1. [How to create a dynamic block](docs/creating-and-registering-dynamic-block.md)
2. [Understanding block directory structure and registration process](docs/block-directory-structure.md)
3. [The block class functionality and configuration](docs/the-block-class-functionality-and-configuration.md)


### General

* [Common modules list and definitions](docs/common-modules-list.md)
* [Extending beyond the basic modules](docs/extending-modules.md)
* [What is Dependency Injection and how to implement it on this plugin](docs/php-di.md)
* [Building assets (JS, CSS) using Webpack](docs/webpack-usage.md)
* [Handling dependencies with WordPress Node packages and global JS packages](docs/wordpress-node-packages.md)
* [Environment variables](docs/environment.md)


### 
## Important Notes
- - - -

### License
This plugin is licensed under the GPL v2 or later.

> This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.

> This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

> You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA

A copy of the license is included in the root of the plugin directory. The file is named `LICENSE`.

This plugin is licensed under the GPL v2 or later; however, if you opt to use third-party code that is not compatible with v2, then you may need to switch to using code that is GPL v3 compatible.

For reference, [here's a discussion](http://make.wordpress.org/themes/2013/03/04/licensing-note-apache-and-gpl/) that covers the Apache 2.0 License used by [Bootstrap](http://twitter.github.io/bootstrap/).
