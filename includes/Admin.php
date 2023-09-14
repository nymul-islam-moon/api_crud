<?php

namespace Api\Crud;

/**
 * The admin class
 */
class Admin {

    /**
     * Initialize the class
     */
    public function __construct() {

        $this->dispatch_actions();
        new Admin\Menu();
    }

    public function dispatch_actions() {

        $contact = new Admin\Contacts();

        add_action( 'admin_init', [ $contact, 'form_handler' ] );
    }
}