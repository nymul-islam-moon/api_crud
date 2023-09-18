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

    }
}