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

        $contact = new Admin\Contacts();

        $this->dispatch_actions( $contact );

        new Admin\Menu( $contact );
    }

    public function dispatch_actions( $contact ) {

        add_action( 'admin_init', [ $contact, 'form_handler' ] );
    }
}