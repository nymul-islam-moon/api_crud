<?php

namespace Api\Crud;

/**
 * API Class
 */
class API {

    public function __construct() {
        add_action( 'rest_api_init', [ $this, 'register_api' ] );
    }

    public function register_api() {
        $contacts = new API\Contacts();
        $contacts->register_routes();
    }
}