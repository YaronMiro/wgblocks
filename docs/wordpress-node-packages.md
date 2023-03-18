# Wordpress Packages
- - - -

WordPress exposes a list of JavaScript packages and tools for WordPress development.

* [Official Repository](https://github.com/WordPress/gutenberg/tree/master/packages)   
includes all the packages alongside their definitions and usage instructions.


* [Official Developer Handbook](https://developer.wordpress.org/block-editor/packages/)   
includes reference package usage for wordpress development.



#### 
### Using Javascript package
- - - -

JavaScript packages are available as a registered script in WordPress and can be accessed using the `wp` global variable.   
If you want to use the `Button` component from the components module, first you would specify `wp-components` as a dependency when you enqueue your script:

```php
<?php
wp_enqueue_script(s
    'my-custom-script-handle',
    plugins_url( $script_path, __FILE__ ),
    array( 'wp-components', 'wp-polyfill' )
);
?>
```

###### 
After the dependency is declared, you can access the module in your JavaScrip code using the global `wp`
 
```js
const { Button } = wp.components;
```

# 
### Using Node Package
- - - -

All the packages are also available on npm if you want to bundle them in your code.   

Advantages in using the node package in development:   

* Having auto completion.
* Code inspection.
* Clean code by not using a global variable.    

Using the same `Button` component example, you would install the ` @wordpress/components` module with npm.

```bash
npm install @wordpress/components --save
```

Once installed, you can access the component in your code.

```js
import { Button }  from '@wordpress/components';

```



#### 
In this way Webpack bundles the `components` module into our `JS script` as part of its source code, this could lead to potential problems such as:

* Having version differences between the node package and the respected Js script that wordpress core uses.

* Duplicated version and global variables conflicts may accrue between the `node bundled module` and the `wp.*` global.    

How can we use the node package and their modules safely ? We can achieve that by using [dependency extraction webpack plugin](https://github.com/WordPress/gutenberg/tree/a481717772f783a29a80d682141b4da62bc8d5a2/packages/dependency-extraction-webpack-plugin).  


#### Dependency Extraction Webpack Plugin

Since we are using Webpack to bundle and generate our JS script, We can leverage that and let Webpack create the PHP dependencies for us.   

Each entry point in the webpack bundle will include an asset file that declares the WordPress `script dependencies` that should be enqueued.   
Such file also contains the unique version hash calculated based on the file content.

For example:
```bash
// Source file entrypoint.js
import { Button } from '@wordpress/components';

// Webpack will produce the output dist/entrypoint.js
/* bundled JavaScript output */

// Webpack will also produce dist/entrypoint.asset.php declaring script dependencies
<?php return array('dependencies' => array('wp-components'), 'version' => 'dd4c2dc50d046ed9d4c063a7ca95702f');
```

This allows JavaScript bundles produced by webpack to leverage WordPress script dependency sharing without an error-prone process of manually maintaining a dependency list.   


#### Getting The Dependencies Asset File Data
We can use the `Common\Assets` module, it has the `getScriptMetaData( $asset_absolute_path )` _method_, that can retrieve the _dependencies asset file_ data. 

For example:   

```php
<?php
	use Company\PluginName\Common\Config;
	use Company\PluginName\Common\Assets;

	$script_relative_path = 'dist/entrypoint.js';
	$script_absolute_path = Config::BASE_DIR . $script_relative_path;
	$script_meta_data = Assets::getScriptMetaData( $script_absolute_path );

	wp_enqueue_script(
		Config::PLUGIN_NAME . '-entrypoint-js',
		$script_meta_data['src'],
		$script_meta_data['dependencies'],
		$script_meta_data['version']
	);
?>
```

We can see that the `getScriptMetaData()` _method_ does a couple of things:

* Retrieves the _script_ `dependencies` from the relative `dist/entrypoint.asset.php` file.

* Retrieves the _script_ `version hash` from the relative `dist/entrypoint.asset.php` file.

* Generate the _script_ `src` for us.

**Note**: This _method_ will only work with an internal _script_ that was generated using the built-in Webpack config of this plugin.


#### Dependency Extraction Supported Modules

By default, the following module requests are handled:

| Request | Global | Script handle |
| --- | --- | --- |
| @babel/runtime/regenerator | regeneratorRuntime | wp-polyfill |
| @wordpress/* | wp['*'] | wp-* |
| jquery | jQuery | jquery |
| lodash-es | lodash | lodash |
| lodash | lodash | lodash |
| moment | moment | moment |
| react-dom | ReactDOM | react-dom |
| react | React | react |
