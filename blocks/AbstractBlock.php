<?php

namespace Webpals\WgBlocks\Blocks;

use Webpals\WgBlocks\Common\Config;
use Webpals\WgBlocks\Common\Assets;

/**
 * Register all actions and filters for the plugin
 *
 * @since		1.0.0
 *
 * @package		WgBlocks
 * @subpackage	WgBlocks/Blocks
 */

/**
 * Helper class for creating Dynamic Gutenberg block.
 *
 * This class utilize the "Template Method" design pattern
 * Template Method is a behavioral design pattern that allows you to defines a
 * skeleton of an algorithm in a base class and let subclasses override the steps
 * without changing the overall algorithm’s structure.
 *
 * @see https://refactoring.guru/design-patterns/template-method/php/example
 *
 * @package		WgBlocks
 * @subpackage	WgBlocks/Blocks
 * @author		Webpals <info@webpals.com>
 */
abstract class AbstractBlock {

	/**
	 * The block directory url.
	 *
	 * @since	1.0.0
	 * @access	private
	 *
	 * @var		string		$blockDirectoryUrl		The block directory url.
	 *
	 */
	private $blockDirectoryUrl = '';

	/**
	 * The block directory file path.
	 *
	 * @since	1.0.0
	 * @access	private
	 *
	 * @var		string		$blockDirectory		The block directory file path.
	 *
	 */
	private $blockDirectory = '';

	/**
	 * The block unique name.
	 *
	 * @since	1.0.0
	 *
	 * @access	private
	 * @var		string		$name		The block unique name.
	 *
	 */
    private $name = '';

	/**
	 * The block attributes.
	 *
	 * @since	1.0.0
	 * @access	private
	 *
	 * @var		array		$attributes		The block attributes, Defined by the
	 * 										block itself. Using setAttributes()
	 * 										abstract function.
	 *
	 */
	private $attributes = array();

	/**
	 * The block scripts list.
	 *
	 * @since	1.0.0
	 * @access	private
	 *
	 * @var		array		$scripts
	 *
	 */
	private $scripts = array();

	/**
	 * The block styles list.
	 *
	 * @since	1.0.0
	 *
	 * @access	private
	 * @var		array		$styles
	 *
	 */
	private $styles = array();

	/**
	 * The block editor script dependencies.
	 *
	 * 	@see	\Webpals\WgBlocks\Blocks\AbstractBlock::setDefaultScripts().
	 *
	 * @since	1.0.0
	 *
	 * @access	protected
	 *
	 * @var		array		$editorScriptDependencies		The block "editor_script" dependencies.
	 *
	 */
	protected $editorScriptDependencies = array();

	/**
	 * The block editor style dependencies.
	 *
	 * 	@see	\Webpals\WgBlocks\Blocks\AbstractBlock::setDefaultScripts().
	 *
	 * @since	1.0.0
	 * @access	protected
	 *
	 * @var		array		$editorStyleDependencies		The block "editor_style" dependencies.
	 *
	 */
	protected $editorStyleDependencies = array();

	/**
	 * The block front script dependencies.
	 *
	 * @since	1.0.0
	 * @access	protected
	 *
	 * @var		array		$scriptDependencies		The block "script" dependencies.
	 *
	 */
	protected $scriptDependencies = array();

	/**
	 * The block front style dependencies.
	 *
	 * 	@see	\Webpals\WgBlocks\Blocks\AbstractBlock::setDefaultStyles().
	 *
	 * @since	1.0.0
	 * @access	protected
	 *
	 * @var		array		$styleDependencies		The block "style" dependencies.
	 *
	 */
	protected $styleDependencies = array();

	/**
	 * The block editor script default dependencies.
	 *
	 * 	@see	\Webpals\WgBlocks\Blocks\AbstractBlock::setDefaultScripts().
	 *
	 * @since	1.0.0
	 * @access	private
	 *
	 * @var		array		EDITOR_SCRIPT_DEFAULTS_DEPENDENCIES
	 *
	 */
    private const EDITOR_SCRIPT_DEFAULTS_DEPENDENCIES = array(
		'wp-element'
	);

	/**
	 * The block editor style default dependencies.
	 *
	 * @since	1.0.0
	 * @access	private
	 *
	 * @var		array		EDITOR_STYLE_DEFAULTS_DEPENDENCIES
	 *
	 */
	private const EDITOR_STYLE_DEFAULTS_DEPENDENCIES = array(
        'wp-edit-blocks'
	);

	/**
	 * The block script default dependencies.
	 *
	 * @since	1.0.0
	 * @access	private
	 *
	 * @var		array		SCRIPT_DEFAULTS_DEPENDENCIES
	 *
	 */
	private const SCRIPT_DEFAULTS_DEPENDENCIES = array();

	/**
	 * The block style default dependencies.
	 *
	 * @since	1.0.0
	 * @access	private
	 *
	 * @var		array		STYLE_DEFAULTS_DEPENDENCIES
	 *
	 */
	private const STYLE_DEFAULTS_DEPENDENCIES = array();

	/**
	 * The block unique namespace.
	 *
	 * @since	1.0.0
	 * @access	private
	 *
	 * @var		string		BLOCKS_NAMESPACE
	 *
	 */
	private const BLOCKS_NAMESPACE = Config::PLUGIN_NAME;

	/**
	 * The block assets types.
	 *
	 * @since	1.0.0
	 * @access	private
	 *
	 * @var		string		ASSETS_TYPES
	 *
	 */
	private const ASSETS_TYPES = array(
		'scripts',
		'styles'
	);

	/**
	 * The block assets dir name.
	 *
	 * @since	1.0.0
	 * @access	private
	 *
	 * @var		string		ASSETS_DIR_NAME
	 *
	 */
	private const ASSETS_DIR_NAME = 'dist';

	/**
	 * Initialize Block registration functionality.
	 *
	 * @since	1.0.0
	 *
	 * @param	string		$block_main_file_path		The "Block.php" main file path.
	 * @param	string		$block_name 				The block name.
	 *
	 */
    function __construct( string $block_main_file_path, string $block_name ) {

		// Set block data.
		$this->name =  $block_name;
		$this->blockDirectory = plugin_dir_path( $block_main_file_path );
		$this->blockDirectoryUrl = plugin_dir_url( $block_main_file_path );
		$this->setDefaultAttributes();
		$this->attributes = array_merge( $this->attributes , $this->setAttributes( $this->attributes ) );

		//  Set Scripts.
		$this->setDefaultScripts();
		$this->scripts = $this->setScripts( $this->scripts );

		// Set Styles.
		$this->setDefaultStyles();
		$this->styles = $this->setStyles( $this->styles );

		// Register all Assets.
		$this->registerAssets();

    }

	/**
	 * Register all block scripts and styles.
	 *
	 * @since	1.0.0
	 * @access	private
	 *
	 */
	private function registerAssets() {

		foreach ( self::ASSETS_TYPES as $asset_type ) {
			foreach ( $this->{$asset_type} as $asset ) {

				$function = $asset_type === 'scripts' ? 'wp_register_script' : 'wp_register_style';

				$function(
					$asset['handle'],
					$asset['src'],
					$asset['dependencies'],
					$asset['version']
				);
			}
		}

	}

	/**
	 * Generate a unique prefix for asset handle by block name.
	 *
	 * @since	1.0.0
	 * @access	private
	 *
	 * @return	string
	 *
	 */
    private function prefixHandle() {
        return self::BLOCKS_NAMESPACE . "-{$this->name}-block";
    }

	/**
	 * Register a dynamic block using the WordPress register_block_type() core function.
	 *
	 * @since	1.0.0
	 *
	 * @see 	Official documentation for registering dynamic block:
	 * @link 	https://developer.wordpress.org/block-editor/tutorials/block-tutorial/creating-dynamic-blocks/
	 *
	 */
    public function registerBlockType() {
        register_block_type(
			$this::getName(),
            array(
                'attributes' 		=> $this->attributes,
                'editor_script' 	=> $this->scripts['editor']['handle'],
                'editor_style' 		=> $this->styles['editor']['handle'],
                'script' 			=> $this->scripts['script']['handle'],
                'style' 			=> $this->styles['style']['handle'],
                'render_callback'	=> array( $this, 'render' )
			)
        );
	}

	/**
	 * Set the default "Attributes".
	 *
	 * @since	1.0.0
	 * @access	private
	 *
	 * @see		\Webpals\WgBlocks\Blocks\AbstractBlock::setAttributes()
	 *
	 * @return	array
	 *
	 */
	private function setDefaultAttributes() {
		$this->attributes;
	}

	/**
	 * Set the default "Scripts" assets definitions.
	 *
	 * @since	1.0.0
	 * @access	private
	 *
	 * @see 	\Webpals\WgBlocks\Blocks\AbstractBlock::setScripts().
	 * @see 	\Webpals\WgBlocks\Blocks\AbstractBlock::getScripts().
	 *
	 * @return	array
	 *
	 */
    private function setDefaultScripts() {

		// Editor.
		$editor_file_relative_path = self::ASSETS_DIR_NAME . '/editor.js';
		$editor_file_absolute_path = $this->blockDirectory . $editor_file_relative_path;
		$editor_meta_data = Assets::getScriptMetaData( $editor_file_absolute_path );
		$editor_dependencies = array_unique(
			array_merge(
				self::EDITOR_SCRIPT_DEFAULTS_DEPENDENCIES,
				$editor_meta_data['dependencies'],
				$this->editorScriptDependencies
			)
		);

		// Script.
		$script_file_relative_path = self::ASSETS_DIR_NAME . '/script.js';
		$script_file_absolute_path = $this->blockDirectory . $script_file_relative_path;
		$script_meta_data = Assets::getScriptMetaData( $script_file_absolute_path );
		$script_dependencies = array_unique(
			array_merge(
				self::SCRIPT_DEFAULTS_DEPENDENCIES,
				$script_meta_data['dependencies'],
				$this->scriptDependencies
			)
		);

		$this->scripts = array(
			'editor' => array(
				'handle' => $this->prefixHandle() . '-editor',
				'src' => $this->blockDirectoryUrl . $editor_file_relative_path,
				'path' => $editor_file_absolute_path,
				'dependencies' => $editor_dependencies,
				'version' => $editor_meta_data['version']
			),
			'script' => array(
				'handle' => $this->prefixHandle() . '-script',
				'src' => $this->blockDirectoryUrl . $script_file_relative_path,
				'path' => $script_file_absolute_path,
				'dependencies' => $script_dependencies,
				'version' => $script_meta_data['version']
			)
		);

	}

	/**
	 * Block can use this function to override the default "Scripts".
	 *
	 *
	 * when overriding the "default scripts" it's important to keep the main associative
	 * keys of the "scripts" array, these keys MUST NOT be overridden.
	 *
	 * The _main keys_ of the "default scripts" array are:
	 *
	 *  - editor
	 *  - script
	 *
	 * The allowed properties that can be overridden for an individual style are:
	 *
	 * - handle
	 * - src
	 * - dependencies
	 * - version
	 *
	 * @since	1.0.0
	 * @access	protected
	 *
	 * @see 	\Webpals\WgBlocks\Blocks\AbstractBlock::setDefaultScripts().
	 *
	 * @param	array		$scripts		The block scripts list.
	 *
	 * @return	array
	 */
	protected function setScripts( $scripts ) {
		return $scripts;
	}


	/**
	 * Set the default "Styles" assets definitions.
	 *
	 * @since	1.0.0
	 * @access	private
	 *
	 * @see 	\Webpals\WgBlocks\Blocks\AbstractBlock::setStyles().
	 * @see 	\Webpals\WgBlocks\Blocks\AbstractBlock::getStyles().
	 *
	 * @return	array
	 *
	 */
    private function setDefaultStyles() {

		$editor_file_relative_path = self::ASSETS_DIR_NAME . '/editor.css';
		$editor_file_absolute_path = $this->blockDirectory . $editor_file_relative_path;

		$style_file_relative_path = self::ASSETS_DIR_NAME . '/style.css';
		$style_file_absolute_path = $this->blockDirectory . $style_file_relative_path;

		$this->styles = array(
			'editor' => array(
				'handle' => $this->prefixHandle() . '-editor',
				'src' => $this->blockDirectoryUrl . $editor_file_relative_path,
				'path' => $editor_file_absolute_path,
				'dependencies' => array_unique(array_merge(self::EDITOR_STYLE_DEFAULTS_DEPENDENCIES, $this->editorStyleDependencies)),
				'version' => Assets::generateStyleVersion( $editor_file_absolute_path )
			),
			'style' => array(
				'handle' => $this->prefixHandle() . '-style',
				'src' => $this->blockDirectoryUrl . $style_file_relative_path,
				'path' => $style_file_absolute_path,
				'dependencies' => array_unique(array_merge(self::STYLE_DEFAULTS_DEPENDENCIES, $this->styleDependencies)),
				'version' => Assets::generateStyleVersion( $style_file_absolute_path )
			)
		);

	}

	/**
	 * Block can use this function to override the default "Styles".
	 *
	 *
	 * when overriding the "default styles" it's important to keep the main associative
	 * keys of the "styles" array, these keys MUST NOT be overridden.
	 *
	 * The _main keys_ of the "default styles" array are:
	 *
	 *  - editor
	 *  - style
	 *
	 * The allowed properties that can be overridden for an individual style are:
	 *
	 * - handle
	 * - src
	 * - dependencies
	 * - version
	 *
	 * @since	1.0.0
	 * @access	protected
	 *
	 * @see 	\Webpals\WgBlocks\Blocks\AbstractBlock::setDefaultStyles().
	 *
	 *
	 * @param	array		$styles		The block styles list.
	 *
	 * @return	array
	 */
	protected function setStyles( $styles ) {
		return $styles;
	}

	/**
	 * Get the block "Scripts".
	 *
	 * @since	1.0.0
	 * @access	protected
	 *
	 * @return	array
	 *
	 */
	protected function getScripts() {
		return $this->scripts;
	}

	/**
	 * Get the block "Styles".
	 *
	 * @since	1.0.0
	 * @access	protected
	 *
	 * @return	array
	 *
	 */
	protected function getStyles() {
		return $this->styles;
	}

	/**
	 * Get the block directory path.
	 *
	 * @since	1.0.0
	 *
	 * @return	string
	 *
	 */
	public function getBlockDirectoryPath() {
		return $this->blockDirectory;
	}

	/**
	 * Get the block directory as a Url.
	 *
	 * @since	1.0.0
	 *
	 * @return	string
	 *
	 */
	public function getBlockDirectoryUrl() {
		return $this->blockDirectoryUrl;
	}

	/**
	 * Get the block name.
	 *
	 * @since	1.0.0
	 * @access	protected
	 *
	 * @see		\Webpals\WgBlocks\Blocks\AbstractBlock::registerBlockType().
	 *
	 * @param	bool		$full_name		Flag to determine the structure of the block name.
	 * 										Set to "true" will returns the block full name .e.g "wg-blocks/block-name"
	 * 										Set to "false" will returns only block name .e.g "block-name"
	 *
	 * @return	string
	 *
	 */
	protected function getName($full_name = true)
	{

		return $full_name ? self::BLOCKS_NAMESPACE . '/' . $this->name : $this->name;
	}

	/**
	 * Set Block "Attributes".
	 *
	 * @since	1.0.0
	 * @access	protected
	 *
	 * Block must define it's own "Attributes".
	 *
	 * @see 	Official documentation:
	 * @link 	https://developer.wordpress.org/block-editor/developers/block-api/block-attributes/
	 *
	 * @param	array		$attributes		The block default attributes.
	 *
	 * @return	array
	 *
	 */
    protected abstract function setAttributes( $attributes );

	/**
	 * The block server-side "Render" callback function.
	 *
	 * @since    1.0.0
	 *
	 * Block must define it's own "Render" function for the front-facing,
	 * for more info:
	 *
	 * @see 	Official documentation for registering dynamic block:
	 * @link 	https://developer.wordpress.org/block-editor/tutorials/block-tutorial/creating-dynamic-blocks/
	 *
	 * @param	array			$attributes		The saved block attributes.
	 * @param	string|HTML		$content		The saved block "innerHTML" or "innerBlocks" as an HTML string.
	 *
	 * @return	string|HTML
	 *
	 */
	public abstract function render( $attributes, $content );

}
