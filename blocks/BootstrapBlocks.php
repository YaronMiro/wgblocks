<?php

namespace Webpals\WgBlocks\Blocks;

use Webpals\WgBlocks\Common\Config;
use DirectoryIterator;


/**
 * The file that defines the core functionality for the plugin Gutenberg blocks.
 *
 * A class definition that includes Blocks registration and functions used across both the
 * front-facing side of the site and the admin area.
 *
 * @since		1.0.0
 *
 * @package		WgBlocks
 * @subpackage	WgBlocks/Blocks
 */

/**
 * The Gutenberg plugin class.
 *
 * This is used to register the blocks and also provide a unique categories for these blocks.
 *
 *
 * @since		1.0.0
 * @package		WgBlocks
 * @subpackage	WgBlocks/Blocks
 * @author		Webpals <info@webpals.com>
 */
final class BootstrapBlocks {


	/**
	 * The block main file name.
	 *
	 * @since	1.0.0
	 *
	 * @var		string		MAIN_BLOCK_FILE_NAME		The block main file name, This is the block class file.
	 *
	 */
	const MAIN_BLOCK_FILE_NAME = 'Block.php';

	/**
	 * The block abstract class name.
	 *
	 * @since	1.0.0
	 *
	 * @var		string		BLOCK_ABSTRACT_CLASS_NAME	The block abstract class name.
	 * @see 	Webpals\WgBlocks\Blocks\AbstractBlock
	 *
	 */
	const BLOCK_ABSTRACT_CLASS_NAME = __NAMESPACE__ . '\AbstractBlock';

	/**
	 * Register Gutenberg Blocks.
	 *
	 * @since	1.0.0
	 *
	 * Register blocks will iterate over the "\blocks" directory, which contains
	 * all of the blocks, Each block has its own directory with a
	 * specific files and directories structure. The registration process expects
	 * to find the block main file named "Block.php" and instantiate the class
	 * registered inside of it, The block class has to be a sub-class
	 * of "Webpals\WgBlocks\Blocks\AbstractBlock"
	 *
	 * @see For more info about registering a Block, please see the README.md file.
	 *
	 */
	public static function registerBlocks() {

		foreach ( new DirectoryIterator( Config::BLOCKS_BASE_DIR ) as $path ) {

			// Block file absolute path.
			$file = $path->getPathname() . DIRECTORY_SEPARATOR . self::MAIN_BLOCK_FILE_NAME;

			// Flag if the path is a directory and is an absolute path.
			$is_directory_abs_path = $path->isDir() && !$path->isDot();

			if ( $is_directory_abs_path  && file_exists( $file ) ) {

				// Get the block class name.
				$current_dir = $path->__toString();
				$block_name = self::pascalCaseToKebabCase( $current_dir );
				$block_class = __NAMESPACE__ . '\\' . $current_dir . '\Block';

				// instantiate the block class and register the block.
				if ( is_subclass_of( $block_class, self::BLOCK_ABSTRACT_CLASS_NAME ) ) {
					$block = new $block_class( $file,  $block_name );
					$block->registerBlockType();
				}

			}
		};

	}

	/**
	 * Register Gutenberg blocks categories.
	 *
	 * This function is a callback for the "block_categories" filter.
	 * @link https://developer.wordpress.org/reference/hooks/block_categories/
	 *
	 * @since	1.0.0
	 *
	 * @param	array		$categories		The existing block categories.
	 * @param	WP_Post 	$post			The current global post obj.
	 * @return	array
	 *
	 */
	public static function registerCategories( $categories, $post ) {

		$new_categories = array(
			 array(
				'slug' => Config::PLUGIN_NAME,
				'title' => __( 'Webpals Blocks', 'wg-blocks' ),
			)
		);

		return array_merge( $new_categories , $categories);
	}

	/**
	 * Transform "camelcase" string onto a "kebab-case".
	 *
	 * Example: "SomeStringText" => "some-string-text".
	 *
	 * @since	1.0.0
	 * @access	private
	 *
	 * @param	string		$string		The target string.
	 * @return	string
	 *
	 */
	private static function pascalCaseToKebabCase( $string ) {
		return strtolower( preg_replace( '/(?<!^)[A-Z]/', '-$0', $string )) ;
	}

}

