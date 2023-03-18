# How To Create a Dynamic Block 
- - - -

In this guide we are going to generate the block on top of an existing _boilerplate code_, this will saves us the process of creating the default block directory and files structure it needs in order for the registration process to work successfully.

## Generating the Block Boilerplate Code `(Step 1)`
- - - - 

There are 2 ways to scaffolding a block:   

A. using the `generate-block` command, fastest and recommend way.   

B. cloning the block skeleton code from the [Example Block](https://bitbucket.org/webpals/gutenberg-example-block) repo and manually altering the boilerplate code, it is still very fast but demands extra steps.   

## 
### (A) Scaffolding with _generate-block_ Command
- - - -

This command will take of everything needed in order to generate a new block, All you need to do is specify the block name.   

block name must be in the format of a `kabab-case` (only lowercase characters, dashes are allowed).

For example, if your block name _"My Block"_

#### 
```bash
npm run generate-block my-block
```

The command will generated the block boilerplate code under the `./blocks` directory in a dedicated directory named `MyBlock`.  

All that's left to do is build the block assets, see `step2` - building the block assets.   

## 
### (B) Manual Scaffolding of the Block Boilerplate Code
- - - -

Clone the [Example Block](https://bitbucket.org/webpals/gutenberg-example-block) repository into the `./blocks/` directory.    

You will need rename cretin texts and files inside of it to fit your needs in the following steps.   

For example, if your block name _"My Block"_:   

Files Changes:   

Rename the block directory from `gutenberg-example-block` to `MyBlock`

Directory name must be case sensitive and, use the format of _PascalCase_, since this is going to be part of the unique _namespace_ for the block.

Text Replacements   

##### 
Open the _Block.php_ file and, edit the _namespace_ switch `ExampleBlock` to `MyBlock`   

```PHP
<?php

namespace Webpals\WgBlocks\Blocks\MyBlock;

?>
```

##### 
Open the _editor.js_ file: 

1. edit the _block-name_ text from `wg-blocks/example-block` to `wg-blocks/my-block`   

2. edit the block _title_ from `'Example Block'` to `'My Block'`

The block name must match its parent directory name, but utilise the format of _kebab-case_, this corresponds to Wordpress strict way of block name convention.

```js
registerBlockType('wg-blocks/my-block', {
	title: __('My Block', 'wg-blocks'),
	// ...
});
```   

All that's left to do is build the block assets, see the step (2) - [building the block assets](#markdown-header-building-the-block-assets).


## 
## Building The Block Assets `(Step 2)`
- - - - 

Run the command from the plugin `root` directory (not the block directory!).

* Build with watch mode => `npm run start`

* Build Once => `npm run build`   

**Note**: Block is automatically registered under the Category named _Webpals Blocks_.

Thats it, you can go and select _My Block_ on the Gutenberg editor :)    



## 
## How to Develope and Configure The Block
- - - - 

The advanced section explains in depth about configuration, functionality and development usage of the block.   

see the _docs_    

* [Understanding block directory structure and registration process](./block-directory-structure.md)

* [The block class functionality and configuration](./the-block-class-functionality-and-configuration.md)

