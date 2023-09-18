<?php
namespace Api\Crud\Admin;

/**
 * The Menu handler class
 */
class Menu {

    public $contact;

    function __construct( $contact ) {
        $this->contact = $contact;
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    public function admin_menu() {

        $parent_slug = 'api_crud';
        $capability = 'manage_options';

        add_menu_page( __( 'Api Crud', 'api_crud' ), __( 'ApiCrud', 'api_crud' ), $capability, $parent_slug, [ $this->contact, 'plugin_page' ], 'dashicons-video-alt3' );

        # Adding sub-menu
        add_submenu_page( $parent_slug, __( 'All Contacts', 'api_crud' ), __( 'Contacts', 'api_crud' ), $capability, $parent_slug, [ $this->contact, 'plugin_page' ] );
        add_submenu_page( $parent_slug, __( 'Add Contacts', 'api_crud' ), __( 'Add Contacts', 'api_crud' ), $capability, 'api_crud_add_contacts', [ $this, 'add_contacts_page' ] );
    }

    public function add_contacts_page() {
        echo "Hello World";
    }

}