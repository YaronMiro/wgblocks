# Common Modules
- - - -

The following modules are dedicated for the common-core functionality of the plugin.   
The module serves a single purpose and, can be used as a part of the plugin life-cycle or as a global utility.   

They can be found under _./common/_ directory. 

**Note:** when this document refers to _HOOKS_, It is referring to the [WordPress API Hooks](https://developer.wordpress.org/plugins/hooks/) (Actions and Filters).

### 
## _Activator_
`Common\Activator`   

This module represents the plugin activation life-cycle and, defines all the necessary logic to run during the plugin's activation.
- - - -


## _Deactivator_
`Common\Deactivator`   

This module represents the plugin deactivate life-cycle and, defines all the necessary logic to run during the plugin's deactivation.
- - - -


## _System_
`Common\System`   

This module represents the plugin engine by implementing core functionality such as _DI Container_ and _Environment Variables_.
- - - -


## _Bootstrap_
`Common\Bootstrap`   

This module represents the plugin functionality and business logic, once it has been activated.   

It serves as the plugin starting point and it's used to bridge between Wordpress _HOOKS_ and the _Modules_ functionality and, does so by declaring  _admin-specific-hooks_, and _front-facing-hooks_ for the site.

**Note:** modules functionality should be decoupled as much as possible and, it is considered a best practice to declare _HOOKS_ only by using the `Common\Loader` inside `Common\Bootstrap` _Method_.

- - - -


## _Loader_
`Common\Loader`   

 This module maintain a list of all _callbacks_ for each _HOOK_ that is registered throughout the plugin and can also execute them.   
 
 **Note:** It is considered a best practice to NOT inject the `Common\Loader` inside other modules beside the `Common\Bootstrap` module, since you want a single source module   
 to declare the _HOOKS_ and execute them using the `Common\Loader` module _methods_.
- - - -



## _Config_
`Common\Config`   

This module holds all the global static values that the plugin will most likely use across most of its existing modules.    
 
The reason for it been static origins with WordPress way of running a _HOOK_ callback. This refers to the cases were we use a class method as a _callback_ for a given _Hook_.   
There are times when we won't be able to pass the _instance_ and will have to use a _static method_.

For the sake of simplicity and consistency we want to use it in the same way across all of our modules, this mean we won't inject it using DI, since it won't work when using a static method.   

You can see how to use it by inspecting the the `Common\TextDomain` module.   

**Note:**  This module should not be used as an instance, and must declare static _methods_ and _properties_.
- - - -


## _Assets_
`Common\Assets`   

This module represents the plugin assets utilities and defines common functionality. 

**Note:**  This module should not be used as an instance, and must declare static _methods_ and _properties_.
- - - -


## _TextDomain_
`Common\TextDomain`   

This module represents the plugin _internationalization_ and defines its functionality.



