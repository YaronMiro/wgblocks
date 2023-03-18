<?php


namespace Webpals\WgBlocks\Common;

/**
 * Define the plugin global configuration.
 *
 *
 * @since		1.0.0
 *
 * @package		WgBlocks
 * @subpackage	WgBlocks/Common
 */


/**
 * Global const for the plugin root directory path.
 *
 *
 * @since	1.0.0
 * @access	public
 * @var		string		WEBPALS_WG_BLOCKS_ROOT_DIR
 */
define('WEBPALS_WG_BLOCKS_ROOT_DIR', dirname(__FILE__, 2));


/**
 * Global const for the plugin url.
 *
 *
 * @since	1.0.0
 * @access	public
 * @var		string		WEBPALS_WG_BLOCKS_URL
 */
define('WEBPALS_WG_BLOCKS_URL', plugin_dir_url(dirname(__FILE__, 1)));


/**
 * Define the plugin global configuration.
 *
 * This class defines all code necessary to init the global configuration of this plugin.
 * The purpose of this class is to declare all of the common static variables, and should
 * NOT be used as an instance.
 *
 * @since		1.0.0
 * @package		WgBlocks
 * @subpackage	WgBlocks/Common
 * @author		Webpals <info@webpals.com>
 */


class Config {

	/**
	 * The plugin unique name.
	 *
	 * @since	1.0.0
	 * @var		string		PLUGIN_NAME		The plugin name.
	 *
	 */
	const PLUGIN_NAME = 'wg-blocks';

	/**
	 * The plugin current version.
	 *
	 * Rename this for your plugin and update it as you release new versions.
	 * Start at version 1.0.0 and use SemVer - https://semver.org
	 *
	 * @since	1.0.0
	 *
	 * @var		string		PLUGIN_VERSION		Currently plugin version.
	 *
	 */
	const PLUGIN_VERSION = '1.0.0';

	/**
	 * The plugin dir path.
	 *
	 * @since	1.0.0
	 *
	 * @var		string		BASE_DIR
	 *
	 */
	const BASE_DIR = WEBPALS_WG_BLOCKS_ROOT_DIR;


	/**
	 * The plugin dir path.
	 *
	 * @since	1.0.0
	 *
	 * @var		string		BASE_DIR		The plugin absolute directory path.
	 *
	 */
	const BLOCKS_BASE_DIR = WEBPALS_WG_BLOCKS_ROOT_DIR . '/blocks';

	/**
	 * The plugin url path.
	 *
	 * @since	1.0.0
	 *
	 * @var		string		BASE_URL
	 *
	 */
	const BASE_URL = WEBPALS_WG_BLOCKS_URL;

	/**
	 * The environment file directory path.
	 *
	 * @since	1.0.0
	 *
	 * @var		string		ENVIRONMENT_FILE_DIRECTORY
	 *
	 */
	const ENVIRONMENT_FILE_DIRECTORY = WEBPALS_WG_BLOCKS_ROOT_DIR;

	/**
	 * The environment file name.
	 *
	 * @since	1.0.0
	 *
	 * @var		string		ENVIRONMENT_FILE_NAME
	 *
	 */
	const ENVIRONMENT_FILE_NAME = '.env';

	/**
	 * To insure this class stays static.
	 *
	 * @since	1.0.0
	 * @access	private
	 *
	 */
	private function __construct() {}

}
