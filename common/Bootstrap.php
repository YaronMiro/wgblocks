<?php

namespace Webpals\WgBlocks\Common;

use Webpals\WgBlocks\Common\Loader;
use Webpals\WgBlocks\Common\TextDomain;
use Webpals\WgBlocks\Blocks\BootstrapBlocks;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * front-facing side of the site and the admin area.
 *
 * @since		1.0.0
 *
 * @package		WgBlocks
 * @subpackage	WgBlocks/Common
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * front-facing site hooks.
 *
 * @since		1.0.0
 * @package		WgBlocks
 * @subpackage	WgBlocks/Common
 * @author		Webpals <info@webpals.com>
 */
class Bootstrap {

	/**
	 * The loader that's responsible for maintaining and registering all hooks
	 * that power the plugin.
	 *
	 * @since	1.0.0
	 * @access	protected
	 * @var		Loader		$loader
	 */
	protected $loader;

	/**
	 * The Text domain class is responsible for internationalization of this plugin.
	 *
	 * @since	1.0.0
	 * @access	protected
	 * @var		TextDomain		$textDomain
	 */
	protected $textDomain;

	/**
	 * This is used to register the blocks of this plugin.
	 *
	 * @since	1.0.0
	 * @access	protected
	 *
	 * @var		BootstrapBlocks		$bootstrapBlocks
	 *
	 */
	protected $bootstrapBlocks;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Define the locale, and set the hooks for the admin area and
	 * the front-facing side of the site.
	 *
	 * @since	1.0.0
	 *
	 * @param	Loader				$loader					Register all actions and filters for the plugin.
	 * @param	TextDomain			$textDomain				Define the internationalization functionality of this plugin.
	 * @param	BootstrapBlocks		$bootstrapBlocks		This is used to register the blocks of this plugin.
	 *
	 */
	public function __construct( Loader $loader, TextDomain $textDomain, BootstrapBlocks $bootstrapBlocks ) {

		$this->loader = $loader;
		$this->textDomain = $textDomain;
		$this->bootstrapBlocks = $bootstrapBlocks;

		$this->setLocale();
		$this->BootstrapBlocks();

		$this->loader->run();
	}


	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Webpals\WgBlocks\Common\TextDomain class in order to set the
	 * domain and to register the hook with WordPress.
	 *
	 * @since	1.0.0
	 * @access	private
	 *
	 */
	private function setLocale() {
		$this->loader->addAction( 'plugins_loaded', $this->textDomain, 'loadPluginTextDomain' );
	}


	/**
	 * Register plugin blocks.
	 *
	 * @since	1.0.0
	 * @access	private
	 *
	 */
	private function BootstrapBlocks() {
		$this->loader->addAction( 'init', $this->bootstrapBlocks, 'registerBlocks' );
		$this->loader->addFilter( 'block_categories', $this->bootstrapBlocks, 'registerCategories',  10, 2 );
	}
}
