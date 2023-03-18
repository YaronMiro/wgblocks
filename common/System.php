<?php

namespace Webpals\WgBlocks\Common;

use DI\ContainerBuilder;
use \Dotenv\Dotenv;
use Error;

/**
 * The file that defines the plugin engine.
 *
 * @since		1.0.0
 *
 * @package		WgBlocks
 * @subpackage	WgBlocks/Common
 */

/**
 * The system DI Container class.
 *
 * Defines the core functionality for using the DI Container mechanism.
 * by utilizing the "Singleton" design pattern, We want to make sure we always use the
 * same instance of the container.
 * @see http://php-di.org/doc/container-configuration.html
 *
 *
 * Inject the environment variables so they accessible on a global level.
 * @see https://github.com/vlucas/phpdotenv

 *
 * @since		1.0.0
 *
 * @package		WgBlocks
 * @subpackage	WgBlocks/Common
 * @author		Webpals <info@webpals.com>
 */
final class System {

	/**
	 * The Container definitions config data.
	 *
	 * @since	1.0.0
	 *
	 * @var		array		DEFINITIONS
	 *
	 * @see http://php-di.org/doc/php-definitions.html
	 */
	const DEFINITIONS = __DIR__ . '/config-definitions.php';

	/**
	 * The environment file is missing error message.
	 *
	 * @since	1.0.0
	 *
	 * @var		array		ENV_MISSING_ERR
	 *
	 */
	const ENV_FILE_IS_MISSING_ERR = 'The environment file (.env) is missing!';

	/**
	 * The container itself.
	 *
	 * @since	1.0.0
	 *
	 * @access	protected
	 * @var		\DI\Container		$container
	 */
	protected $container;

	/**
	 * The class single instance.
	 *
	 * @since	1.0.0
	 *
	 * @access	protected
	 * @var		System		$instance
	 */
	protected static $instance;

	/**
	 * Builds the container.
	 *
	 * @since	1.0.0
	 *
	 * @access	protected
	 */
	protected function __construct() {

		$this->buildContainer();

	}

	/**
	 * The static instantiation  callback for this class.
	 *
	 * @since	1.0.0
	 *
	 * @return	System
	 *
	 */
	public static function getInstance() {

		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Get the container object.
	 *
	 * @since	1.0.0
	 *
	 * @return	\DI\Container
	 *
	 */
	public function getContainer() {

		return $this->container;

	}

	/**
	 * Loads the environment variables as globals.
	 *
	 * @since	1.0.0
	 *
	 * @param	string		$environment_file_dir
	 * @param	string		$file_name
	 *
	 * @see		https://github.com/vlucas/phpdotenv
	 *
	 */
	public static function loadEnvironment( $environment_file_dir, $file_name ) {

		if ( !file_exists( $environment_file_dir .DIRECTORY_SEPARATOR . $file_name ) ) {
			throw new Error( self::ENV_FILE_IS_MISSING_ERR );
		}

		$dotenv = Dotenv::createImmutable( $environment_file_dir,  $file_name);
		$dotenv->load();

	}

	/**
	 * The callback that builds the container.
	 *
	 * @since	1.0.0
	 *
	 * @return	\DI\Container
	 *
	 */
	protected function buildContainer() {

		$builder = new ContainerBuilder();
		$builder->addDefinitions( $this::DEFINITIONS );
		$this->container = $builder->build();

	}
}

