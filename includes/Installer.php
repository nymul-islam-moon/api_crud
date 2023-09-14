<?php

namespace Api\Crud;

/**
 * Installer class
 */
class Installer {

    /**
     * Run the installer
     *
     * @return void
     */
    public function run() {
        $this->add_version();
        $this->create_tables();
    }

    public function add_version() {
        $installed_time = get_option( 'api_crud_installed_time' );
        if ( ! $installed_time ) {
            update_option( 'api_crud_installed_time', time() );
        }
        update_option( 'api_crud_version', API_CRUD_VERSION );
    }

    /**
     * Create necessary tables
     *
     * @return void
     */
    public function create_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}api_crud_contacts` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(100) NOT NULL DEFAULT '',
            `email` varchar(50) DEFAULT NULL,
            `address` varchar(255) DEFAULT NULL,
            `created_by` bigint(20) unsigned NOT NULL,
            `created_at` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate";

        if ( ! function_exists( 'dbDelta' ) ) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }
        dbDelta( $schema );
    }
}