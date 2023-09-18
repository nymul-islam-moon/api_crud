<?php

namespace Api\Crud\Admin;

class Contacts {

    public $errors = [];

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

        if ( empty( $_POST['name'] ) ) {
            $this->errors['name'] = __( 'Please provide a name', 'api_crud' );
        }

        if ( empty( $_POST['email'] ) ) {
            $this->errors['email'] = __( 'Please provide a email', 'api_crud' );
        }

        if ( ! empty( $this
        ->errors) ) {
            return;
        }

        $name = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
        $email = isset( $_POST['email'] ) ? sanitize_text_field( $_POST['email'] ) : '';
        $address = isset( $_POST['address'] ) ? sanitize_textarea_field( $_POST['address'] ) : '';

        $message = wd_ac_insert_contact([
            'name'      => $name,
            'email'     => $email,
            'address'   => $address,
        ]);

        $redirected_to = admin_url( 'admin.php?page=api_crud&inserted=true' );

        wp_redirect( $redirected_to );
//        echo 'Success or error message';

        exit();
    }
}