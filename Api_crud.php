<?php

/*
 * Plugin Name:       API CRUD
 * Plugin URI:        https://github.com/nymul-islam-webappick
 * Description:       First plugin with API CRUD.
 * Version:           0.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Nymul Islam Moon
 * Author URI:        https://nymul-islam-moon.github.io/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */

/*
{API CRUD} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

{API CRUD} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with {API CRUD}. If not, see {URI to Plugin License}.
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

final class Api_crud {

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '0.0.1';

    /**
     * Constructor for the main Api_crud class
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initializes a singleton instance
     *
     * @return \Api_crud
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'API_CRUD_VERSION',  self::version );
        define( 'API_CRUD_FILE', __FILE__ );
        define( 'API_CRUD_PATH', __DIR__ );
        define( 'API_CRUD_URL', plugins_url( '', API_CRUD_FILE ) );
        define( 'API_CRUD_ASSETS', API_CRUD_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {

        if ( is_admin() ) {
            new Api\Crud\Admin();
        } else {
            new Api\Crud\Ppublic();
        }

        new Api\Crud\API();
    }

    /**
     * Do stuff plugin activation
     *
     * @return void
     */
    public function activate() {
        $installer = new Api\Crud\Installer();
        $installer->run();
    }
}

/**
 * Initializes the main plugin
 *
 * @return \Api_crud
 */
function api_crud() {
    return Api_crud::init();
}

# Kick off the plugin
api_crud();

# https://www.facebook.com/actionentertainmentmovies/