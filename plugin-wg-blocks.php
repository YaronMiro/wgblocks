<?php

namespace Webpals\WgBlocks;


/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             1.0.0
 * @package           WgBlocks
 *
 * @wordpress-plugin
 * Plugin Name:       Webpals Blocks - Gutenberg Blocks Collection
 * Plugin URI:        http://example.com/wg-blocks-uri/
 * Description:       Collection of Gutenberg blocks for the WordPress editor.
 * Version:           1.0.0
 * Author:            Webpals
 * Author URI:        http://webpals.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wg-blocks
 * Domain Path:       /languages
 */

use Webpals\WgBlocks\Common\System;
use Webpals\WgBlocks\Common\Activator;
use Webpals\WgBlocks\Common\Deactivator;
use Webpals\WgBlocks\Common\Bootstrap;
use Webpals\WgBlocks\Common\Config;


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs the auto-loading mechanism.
 */
require_once(dirname(__FILE__) . '/vendor/autoload.php');


 /**
 * The code that runs during plugin activation.
 * This action is documented in common/Activator.php
 */
register_activation_hook(__FILE__, function (){
	Activator::activate();
});


/**
 * The code that runs during plugin deactivation.
 * This action is documented in common/Deactivator.php
 */
register_deactivation_hook(__FILE__, function (){
	Deactivator::deactivate();
});


/**
 * Begins execution of the plugin.
 *
 * @since	1.0.0
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 */
function run() {

	// Load Environment Variables.
	System::loadEnvironment( Config::ENVIRONMENT_FILE_DIRECTORY, Config::ENVIRONMENT_FILE_NAME );

	// Use the container to instantiate the bootstrap process.
	System::getInstance()->getContainer()->get( Bootstrap::class );

}

run();
