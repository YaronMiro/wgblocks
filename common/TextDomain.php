<?php

namespace Webpals\WgBlocks\Common;

use Webpals\WgBlocks\Common\Config;

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since		1.0.0
 *
 * @package		WgBlocks
 * @subpackage	WgBlocks/Common
 */

/**
 * Define the internationalization functionality.
 *
 * This class defines all code necessary to the internationalization of this plugin
 * so that it is ready for translation.
 *
 * @since		1.0.0
 * @package		WgBlocks
 * @subpackage	WgBlocks/Common
 * @author		Webpals <info@webpals.com>
 */
class TextDomain {


	/**
	 * The languages files directory path of this plugin.
	 *
	 * @since	1.0.0
	 *
	 * @var		string		LANGUAGES_DIR		The directory holding all the translation files this plugin declares.
	 *
	 */
	const LANGUAGES_DIR = Config::BASE_DIR . DIRECTORY_SEPARATOR  . 'languages' . DIRECTORY_SEPARATOR;


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since	1.0.0
	 *
	 */
	public function loadPluginTextDomain() {
		load_plugin_textdomain(
			Config::PLUGIN_NAME,
			false,
			self::LANGUAGES_DIR
		);
	}
}
