<?php

namespace Webpals\WgBlocks\Common;

use Error;

/**
 * The file that defines the Assets utilities.
 *
 *
 * @since		1.0.0
 *
 * @package		PluginName
 * @subpackage	PluginName/Common
 */

/**
 * Define the assets utilities functionality.
 *
 * The purpose of this class is to declare all of its properties and methods
 * static variables, and should NOT be used as an instance.
 *
 * @since		1.0.0
 * @package		PluginName
 * @subpackage	PluginName/Common
 * @author		Webpals <info@webpals.com>
 */
class Assets {

	/**
	 * The asset dependencies file placeholder name.
	 *
	 * @since	1.0.0
	 *
	 * @var		string		DEPENDENCIES_FILE_NAME_PLACEHOLDER		Dependencies file name is structured out of
	 * 																[FILE_NAME] => equivalent to the asset Webpack
	 * 																entry point and is always followed by ".asset.php".
	 *
	 */
	const DEPENDENCIES_FILE_NAME_PLACEHOLDER = '[FILE_NAME].asset.php';


	/**
	 * The asset dependencies file is missing error message.
	 *
	 * @since	1.0.0
	 *
	 * @var		array		ENV_MISSING_ERR
	 *
	 */
	const DEPENDENCIES_FILE_IS_MISSING_ERR = 'Missing dependencies file for' ;


	/**
	 * Get the script metadata.
	 *
	 * @since	1.0.0
	 *
	 * The script (JS) metadata file is generated using webpack plugin named "dependency-extraction-webpack-plugin".
	 * THe default behavior of Webpack plugin is tp generate the asset dependencies file relative to the asset itself.
	 *
	 * @see		https://github.com/WordPress/gutenberg/tree/master/packages/dependency-extraction-webpack-plugin/
	 * @see		docs/wordpress-node-packages.md
	 *
	 * @param	string		$asset_absolute_path
	 *
	 * @param	array
	 *
	 */
	public static function getScriptMetaData( $asset_absolute_path )
	{

		// Default metadata values.
		$metadata = array(
			'src' => str_replace( Config::BASE_DIR, Config::BASE_URL, $asset_absolute_path ),
			'dependencies' => array(),
			'version' => Config::PLUGIN_VERSION
		);

		$path_info = pathinfo( $asset_absolute_path );
		$asset_file_name = str_replace( '[FILE_NAME]', $path_info['filename'], self::DEPENDENCIES_FILE_NAME_PLACEHOLDER );
		$asset_dependencies_file_path = $path_info['dirname'] . DIRECTORY_SEPARATOR . $asset_file_name;

		if ( !file_exists( $asset_dependencies_file_path ) ) {
			return $metadata;
		}

		// Get the 'version' and 'dependencies'.
		$metadata =  array_merge( $metadata, include( $asset_dependencies_file_path ) );

		return $metadata;
	}


	/**
	 * Generate the style version.
	 *
	 * The version represents the file "change timestamp" and, should be used
	 * for cache purposes as when registering or enqueuing a given style as
	 * its "version" value.
	 *
	 * @since	1.0.0
	 *
	 *
	 * @param	string		$style_absolute_path

	 * @return	string
	 *
	 */
	public static function generateStyleVersion( $style_absolute_path ){
		return file_exists( $style_absolute_path ) ? filemtime( $style_absolute_path ) : Config::PLUGIN_VERSION;
	}

	/**
	 * To insure this class stays static.
	 *
	 * @since	1.0.0
	 * @access	private
	 *
	 */
	private function __construct() {}

}
