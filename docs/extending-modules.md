# Extending Beyond The Basic Modules
- - - -

The plugin is just a starting point of boilerplate code and won't have all the modules you need when developing a dedicated plugin of your own.

This document will guide you on how to add a new module, this is considered to be the best practice of doing it,
but it's up to you to choose the implementation to do so depending on your needs.

It is also recommended to read about the plugin implementation of [PHP DI](php-di.md).

### 
## Creating the module
- - - -

For example, if your module is named 'my-module':

1. create a directory named `my-module` on the plugin _root_ directory

2. extend `composer.json` with `"Company\\PluginName\\MyModule\\": "./my-module"` namespace alias.

3. update Composer by running the following command `composer dump-autoload`

4. create a php file named `MyModuleClass` inside the `my-module` directory

5. add the correct namespace to your module PHP file => `namespace Company\PluginName\MyModule;`

6. create the `MyClass` class with the following methods `addAssets()` and `appendToContent()`  
 
```PHP
<?php
namespace Company\PluginName\MyModule

class MyClass {

	public function addAssets() {
		// Add assets...
	}

	public function appendToContent() {
		// Add more content...
	}

}
?>
```
### 
## Injecting the module
- - - -

Inject our module into `Common\Bootstrap` constructor method, since this is the plugin single start point. This can be done by implementing the PHP DI dependency injection [Autowiring](http://php-di.org/doc/autowiring.html).
 
```PHP
<?php
use use Company\PluginName\MyModule\MyClass;

// Inside Common\Bootstrap::class.
public function __construct( ..., MyClass $myClass ) {
	$this->myClass = $myClass;
}
?>
```

### 
## Using the module
- - - -

Once we have injected our module as a dependency of the `Common\Bootstrap`, then we are able to use its internal functionality as callbacks inside WordPress [_HOOKS_](https://developer.wordpress.org/plugins/hooks/) - Actions & Filters.   

This can be done by adding a new method named `defineMyClassHooks()` into the `Common\Bootstrap` and using the `Common\Loader` methods `addAction()` or `addFilter()` inside of it.
 
```PHP
<?php

// Inside Common\Bootstrap::class.
private function defineMyClassHooks( ..., MyClass $myClass ) {
	$this->loader->addAction( 'wp_enqueue_scripts', $this->myClass, 'addAssets' );
	$this->loader->addFilter( 'the_content', $this->myClass, 'appendToContent' );
}

?>
```
