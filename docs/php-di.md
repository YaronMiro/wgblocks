# Dependency Injection
- - - -

## What is Dependency Injection

* [Understanding Dependency Injection](http://php-di.org/doc/understanding-di.html)
* [Getting started with PHP-DI](http://php-di.org/doc/getting-started.html)


## Injecting with Autowiring
- - - -

Autowiring represents something very simple: the ability of the container to automatically create and inject dependencies.  
When _PHP-DI_ needs to create the `MyClass`, it detects that the constructor takes a `SomeService` object (using the type hinting).   

###### 
```PHP
<?php
class SomeService {
    // ...
}

class MyClass {
    public function __construct( SomeService $someService ) {
        // ...
    }
}
?>
```

Without any configuration, _PHP-DI_ will create a `MyClass` instance (if it wasn't already created) and, it will pass it as a constructor parameter.   

The equivalent raw PHP code would be: 

###### 
```PHP
<?php
$some_service = new SomeService();
$my_class = new MyClass( $some_service  );
?>
```


## 
## The DI Container   
- - - -

#### Rules for using a container and dependency injection

Here are some basic rules to follow:   

1. never get an entry from the container directly (always use dependency injection).
2. more generally, write code decoupled from the container.
3. type-hint against interfaces, configure which implementation to use in the container's configuration.



## 
#### Getting the Container

The `container` is configured using the `Common\System` and is accessible as singleton by using the built-in `getContainer()` _method_.   

for example in order to instantiate the `Common\Bootstrap` then we need could use this:

##### 
```PHP
<?php
use use Company\PluginName\Common\System;

$system = System::getInstance();
$bootstrap = $system->getContainer()->get( Bootstrap::class );
?>
```

The `getContainer()` _method_ is just an abstraction layer on top of _PHP DI_ and holds the _container object_.   

This _container_ has a rich functionality, for more info about it see [PHP DI - Using the container](http://php-di.org/doc/container.html).



## 
#### Settings Container Definitions   
In most cases we can use the [PHP DI Autowiring](http://php-di.org/doc/autowiring.html) and the container will know how to resolve the dependency and instantiate it.   

_Autowiring_ has its on [limitations](http://php-di.org/doc/autowiring.html#limitations) and, it will need tha assistance of [Container Definitions](http://php-di.org/doc/php-definitions.html) to resolve and instantiate the dependency.

The `container definitions` can be declared on the following file `common\config-definitions.php`
