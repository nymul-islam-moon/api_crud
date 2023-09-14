<?php

namespace Api\Crud\API;

use http\Params;
use WP_REST_Controller;
use WP_REST_Server;

class Contacts extends WP_REST_Controller {

    function __construct() {
        $this->namespace = 'contact/v1';
        $this->rest_base = 'all';
    }

    public function register_routes() {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base,
            [
                [
                    'method'                => WP_REST_Server::READABLE,
                    'callback'              => [ $this, 'get_items' ],
                    'permission_callback'   => [ $this, 'get_items_permissions_check' ],
                    'args'                  => $this->get_collection_params(),
                ],
                [
                    'methods'               => WP_REST_Server::CREATABLE,
                    'callback'              => [ $this, 'create_item' ],
                    'permission_callback'   => [ $this, 'create_item_permissions_check' ],
                    'args'                  => $this->get_endpoint_args_for_item_schema( WP_REST_Server::CREATABLE ),
                ],
                'schema' => [ $this, 'get_item_schema' ],
            ]
        );
    }

    /**
     * check if a given request has access to read the contacts
     * @param $request
     * @return boolean
     */
    public function get_items_permissions_check($request) {
        if ( current_user_can( 'manage_options' ) ) {
            return true;
        }

        return false;
    }

    /**
     * Retrieves a list of contact items
     * @param $request
     * @return void|\WP_Error|\WP_REST_Response
     */
    public function get_items($request) {
        $args = [];
        $params = $this->get_collection_params();

        foreach ( $params as $key => $value ) {
            if ( isset( $request[ $key ] )) {
                $args[ $key ] = $request[ $key ];
            }
        }

//        $contacts =
        return [
            'className'     => 'Contacts',
            'lineNumber'    => 63,
        ];
    }

    /**
     * Retrieves the contact schema, conforming to JSON Schema
     *
     * @return array|void
     */
    public function get_item_schema() {
        if ( $this->schema )  {
            return $this->add_additional_fields_schema( $this->schema );
        }

        $schema = [
            'schema'        => 'http//json-schema.org/draft-04/schema#',
            'title'         => 'contact',
            'type'          => 'object',
            'properties'    => [
                'id'    => [
                    'description'   => __( 'Unique identifier foo the object;' ),
                    'type'          => 'integer',
                    'context'       => [ 'view', 'edit' ],
                    'readonly'      => true,
                ],
                'name'      => [
                    'description'   => __( 'Name of the contact' ),
                    'type'          => 'string',
                    'context'       => [ 'view', 'edit' ],
                    'arg_options'   => [
                        'sanitize_callback'     => 'sanitize_textarea_field',
                    ],
                ],
                'email'     => [
                    'description'   => __( 'Email of the contact' ),
                    'type'          => 'string',
                    'required'      => true,
                    'context'       => [ 'view', 'edit' ],
                    'arg_options'   => [
                        'sanitize_callback'     => 'sanitize_textarea_field',
                    ],
                ],
                'address'   => [
                    'description'   => __( 'Address of the contact' ),
                    'type'          => 'string',
                    'required'      => true,
                    'context'       => [ 'view', 'edit' ],
                    'arg_options'   => [
                        'sanitize_callback'     => 'sanitize_textarea_field',
                    ],
                ],
                'date'      => [
                    'description'   => __( "The date the object was published, in the site" ),
                    'type'          => 'string',
                    'format'        => 'date-time',
                    'context'       => [ 'view' ],
                    'readonly'      => true,
                ]
            ]
        ];
    }

    /**
     * Check if a given request has access to create items
     *
     * @param $request
     * @return bool|true|\WP_Error
     */
    public function create_item_permissions_check($request)
    {
        return $this->get_items_permissions_check();
    }

    /**
     * Retrieves the query params for collections
     *
     * @return array
     */
    public function get_collection_params()
    {
        $params = parent::get_collection_params();

        unset( $params['search'] );

        return $params;
    }

    /**
     * Create one item from the collection
     * @param $request
     * @return void|\WP_Error|\WP_REST_Response
     */
    public function create_item($request) {
        $contact = $this->prepare_item_for_database( $request );

        if ( is_wp_error( $contact ) ) {
            return $contact;
        }

//        $contact_id =
    }
}