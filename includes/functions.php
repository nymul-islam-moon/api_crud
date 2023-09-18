<?php


/**
 * insert | update a contact
 * @param $args
 * @return Message
 */
function wd_ac_insert_contact( $args = [] ) {

    if ( empty( $args['name'] ) ) {
        return new \WP_Error( 'no-name', __( 'You must provide a name', 'api_crud' ) );
    }
    if ( empty( $args['email'] ) ) {
        return new \WP_Error( 'no-name', __( 'You must provide a E-mail', 'api_crud' ) );
    }

    if ( empty( $args['address'] ) ) {
        return new \WP_Error( 'no-name', __( 'You must provide a Address', 'api_crud' ) );
    }


    $defaults = [
        'name'          => '',
        'email'         => '',
        'address'       => '',
        'created_at'    => current_time( 'mysql' ),
        'created_by'    => get_current_user_id(),
    ];

    $filtered_data = wp_parse_args( $args, $defaults );

    $data = [];

    $data = get_option( 'contact_option_column' );

    array_push( $data, $filtered_data );

    $inserted = update_option('contact_option_column', $data);

    if ( ! $inserted ) {
        return new \WP_Error( 'failed-to-insert', __( 'failed to insert data', 'api_crud' ) );
    }

    $contact = $filtered_data;

    return $contact;

}

//SELECT * FROM `wp_options` WHERE `option_name`='contact_option_column';

function wd_ac_get_contacts( $args = [] ) {

}