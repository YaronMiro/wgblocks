# The Block Class Functionality and Configuration
- - - -

This document describe in depth about the configuration, functionality of the `Block::class` and , will cover the following topics:

* The available _methods_ and  _properties_ of the class.   

* Configuring the block assets ( _js_, _css_ ) and their dependencies using this class.


## About Block Class
- - - -

Block declares its own `Block::class` on the _Block.php_, this file is located on the block _root_ directory.   

This _class_ has several purposes for configuring the dynamic block:   

#### Setting the Block Attributes:    
Define the block _attributes_ - see official Gutenberg docs on how to [declare attributes](https://developer.wordpress.org/block-editor/developers/block-api/block-attributes/).      

#### Setting the Block Server-Side Render:    
Defining the block _server-side render_ output.

#### Setting the Block Assets:    
Defining the block assets, we usually have no reason to alter the _Default Assets_ definitions, despite an asset _dependency_ in some occasions, but have the flexibility to alter them if needed.


## 
## Class Methods
- - - -

#### setAttributes( _$attributes_ )   
Sets the block _Attributes_ - This _method_ is mandatory and must be declared.

##### _Parameters:_   

#####     
`$attributes` ( _Array_ )   

The block _default attributes_.   

#####  _Returns:_

( _`Array`_ ) - Attributes list.




# 
#### render( _$attributes_, _$content_ )   
- - - -
The block server-side _Render_ callback function - This _method_ is mandatory and must be declared.

##### _Parameters:_   

#####     
`$attributes` ( _Array_ )   

The saved block _attributes_.  

These are the block attributes to be used for the server side rendering.   


###    
`$content` ( _String_ | _HTML_ )   


The saved block "innerHTML" or "innerBlocks" as an HTML string.   

#####  _Returns:_

( _`string`_ | _`HTML`_ ) - The render output of the block (visual).




# 
#### setScripts( _$scripts_ )   
- - - -

Block can use this _method_ to override the _Default Scripts_. 

This is a basic callback function that enables the ability to change the _Default Scripts_ before they are registered. 

##### _Parameters:_    

##### 
`$scripts` ( _Array_ )   

The _Default Scripts_ that were set by the `Blocks\AbstractBlock::class`.   

####  
Overriding the _Default Scripts_ array, it's important to keep the main associative keys of the _Default Scripts_ array in tact.   
The main keys of the _Default Scripts_ array are:    

* _editor_   

	This key is been used as reference behind the scenes in The WordPress built-in [_register_block_type()_](https://developer.wordpress.org/reference/functions/register_block_type/) function, It points the _script handle_ to be enqueued for the `editor_script` array key on the function `args` parameter.

* _script_   

	This key is been used as reference behind the scenes in The WordPress built-in [_register_block_type()_](https://developer.wordpress.org/reference/functions/register_block_type/) function, It points the _script handle_ to be enqueued for the `script` array key on the function `args` parameter.

#### 
The allowed _properties_ that can be overridden for an individual _script_ are:   

* _handle_   

* _src_   

* _dependencies_   

* _version_

#####  _Returns:_

( _`Array`_ ) - Scripts list.




# 
#### setStyles( _$styles_ )   
- - - -

Block can use this _method_ to override the _Default Styles_.  

This is a basic callback function that enables the ability to change the _Default Styles_ before they are registered. 


##### _Parameters:_    

##### 
`$styles` ( _Array_ )   

The _Default Styles_ that were set by the `Blocks\AbstractBlock::class`.    

####  
Overriding the _Default Styles_ array, it's important to keep the main associative keys of the _Default Styles_ array in tact.   
The main keys of the _Default Styles_ array are:   

* _editor_   

	This key is been used as reference behind the scenes in The WordPress built-in [_register_block_type()_](https://developer.wordpress.org/reference/functions/register_block_type/) function, It points the _script handle_ to be enqueued for the `editor_style` array key on the function `args` parameter.

* _style_   

	This key is been used as reference behind the scenes in The WordPress built-in [_register_block_type()_](https://developer.wordpress.org/reference/functions/register_block_type/) function, It points the _script handle_ to be enqueued for the `style` array key on the function `args` parameter.

#### 
The allowed _properties_ that can be overridden for an individual _style_ are:   

* _handle_   

* _src_   

* _dependencies_   

* _version_

#####  _Returns:_

( _`Array`_ ) - Styles list.




# 
#### getName( _$full_name = true_ )   
- - - -
Returns the block _Name_.   

##### _Parameters:_    

##### 
`$full_name` ( _String_ )   

Flag to determine the structure of the _block name_ and is set by default to _true_.   

When set to _true_ will return the block full name .e.g `wg-blocks/block-name`   
When set to _false_ will return only block name .e.g `block-name`   

#####  _Returns_:

( _`String`_ ) - The block name.




# 
#### getScripts()   
- - - -
Returns the block _Scripts_.   

#####  _Returns_:

( _`Array`_ ) - Scripts list.




# 
#### getStyles()   
- - - -
Returns the block _Styles_.   

#####  _Returns_:

( _`Array`_ ) - Styles list.



# 
#### getBlockDirectoryPath()   
- - - -
Returns the block _directory path_.   

#####  _Returns_:

( _`String`_ ) - The block directory path.



# 
#### getBlockDirectoryUrl()   
- - - -
Returns the block directory as a _Url_.   

#####  _Returns_:

( _`String`_ ) - The block directory url.




# 
## Class Properties
- - - -

#### $editorScriptDependencies

( _`Array`_ ) - List of _js_ script dependencies for the _editor.js_ file.   

The _dependencies_ declared on this array are appended on top of any existing dependency that was already declared for the _editor.js_ file. Usually there is no need to extended this list, since the block manages an internal dependency extraction mechanism.   

List of dependencies can be found `$this->scripts['editor'][dependencies]`.

See more info in _docs_:   

* [handling JS dependencies](./wordpress-node-packages.md).

* [Understanding block directory structure and registration process](./block-directory-structure.md).   




## 
#### $editorStyleDependencies
- - - -

( _`Array`_ ) - List of _css_ style dependencies for the _editor.css_ file.   

The _dependencies_ declared on this array are appended on top of any existing dependency that was already declared for the _editor.css_ file.   

List of existing dependencies can be found `$this->styles['editor'][dependencies]`.   

See more info in _docs_ - [Understanding block directory structure and registration process](./block-directory-structure.md).   




## 
#### $scriptDependencies
- - - -

( _`Array`_ ) - List of _js_ script dependencies for the _script.js_ file.   

The _dependencies_ declared on this array are appended on top of any existing dependency that was already declared for the  _script.js_ file. The current version does not add any pre-defined dependencies for the _script.js_ file, But a future version of the plugin may declare such dependencies.   

List of existing dependencies can be found `$this->scripts['script'][dependencies]`.

See more info in _docs_:   

* [handling JS dependencies](./wordpress-node-packages.md).

* [Understanding block directory structure and registration process](./block-directory-structure.md).  




## 
#### $styleDependencies
- - - -

( _`Array`_ ) - List of _css_ style dependencies for the _style.css_ file.   

The _dependencies_ declared on this array are appended on top of any existing dependency that was already declared for the _style.css_ file. The current version does not add any pre-defined dependencies for the _script.js_ file, But a future version of the plugin may declare such dependencies.

List of existing dependencies can be found `$this->styles['style'][dependencies]`.   

See more info in _docs_ - [Understanding block directory structure and registration process](./block-directory-structure.md).   
