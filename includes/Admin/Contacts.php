<?php

namespace Api\Crud\Admin;

class Contacts {

    public function plugin_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';

        switch ( $action ) {
            case 'new':
                $template = __DIR__ . '/views/contact-new.php';
                break;

            case 'edit':
                $template = __DIR__ . '/views/contact-edit.php';
                break;

            case 'view':
                $template = __DIR__ . '/views/contact-view.php';
                break;

            default:
                $template = __DIR__ . '/views/contact-list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    /**
     * Handle the form
     *
     * @return void
     */
    public function form_handler() {
        if ( ! isset( $_POST['submit_contact'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'new_contact' ) ) {
            wp_die( 'Are you kidding!?' );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'You are not admin' );
        }

        var_dump( $_POST );
        exit();
    }
}