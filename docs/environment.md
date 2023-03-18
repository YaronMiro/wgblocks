# Environment Variables
- - - -
The environment variables are defined on the `.env` file, which is located under the plugin _root_ directory.   

**Note**: This file is ignored by GIT (security reasons) and must be created separately on each environment.

### 
The syntax it uses is a `KEY=VALUE` pair and also supports nested variables, Let's look at an example:    

```bash
# Basic.
BASE_DIR="some-path"

# Nested.
CACHE_DIR="${BASE_DIR}\cache\"
```   

### 
The implementation is based upon these libraries:  

* [PHP dotenv](https://github.com/vlucas/phpdotenv), adds support on PHP environment.  

* [dotenv-expand](https://github.com/motdotla/dotenv-expand), adds support on Node.js environment.   


On the following sections we can see how this plugin implemented the usage on top of these libraries.

### 
## Webpack Config    
- - - -
In order to use it with Webpack, we can use and access the global `process.env` variable.   

The _process.env_ has access to the entire _.env_ variables since it access it upon the build time process, there is no security risk, unless someone hacked your server :( .

You can see an example on `webpack.config.js` file, it uses the `isDevelopment()` function to configure Webpack build process, by using data form the _.env_ file.   


### 
## Arbitrary JS    
- - - -

Our Js code is running on the client machine, therefore we must consider the security aspect and limit the direct access to the _.env_ file data.

To get data from the _.env_ file we can use the built-in Webpack [DefinePlugin](https://webpack.js.org/plugins/define-plugin/) plugin, it will only expose variables that are defined inside of it, this way we choose what variable we want to expose.

The variables are exposed as global and should be configured on the _webpack.config.js_ file.   

**Note**:   
Remember that the creation of the global variables by Webpack happens once at build time, the client does not read straight from _.env_ file for security reasons as mentioned.    
In the case you update a variable on the _.env_ that was used and exposed on the _DefinePlugin_, you will need to run the Webpack build process in order to get the updated value.

### 
Let's look at an example:    

```js

new webpack.DefinePlugin({
	'process.env.ENVIRONMENT_TYPE': JSON.stringify(process.env.ENVIRONMENT_TYPE),
	'BROWSER_SUPPORTS_HTML5': JSON.stringify(true),
}),
```   

These variables can be accessed using a global variable named `process.env`. You can alter the mapping freely by editing `webpack.config.js` and exposing variables according to your needs.   

```js
const environmentType = process.env.ENVIRONMENT_TYPE;
const hasSupportforHTML = BROWSER_SUPPORTS_HTML5;
```

### 
## PHP (Server)    
- - - -
All variables defined on the _.env_ file are accessible by using:    

* The built-in PHP`getenv()` function
* The super global `$_ENV` variable.
* The super global `$_SERVER` variable.  

**Note**: The server read straight from the _.env_ file on every request so it always in sync and exposed to all the variables declared on that file.

Let's look at an example:    

```php
$environment_type = getenv('ENVIRONMENT_TYPE');   
$environment_type = $_ENV['ENVIRONMENT_TYPE'];   
$environment_type = $_SERVER['ENVIRONMENT_TYPE'];
```
