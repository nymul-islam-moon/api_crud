<?php

namespace Api\Crud\API;

use WP_REST_Controller;
use WP_REST_Server;

/**
 * Contacts Class
 */
class Contacts extends WP_REST_Controller {

    public function __construct() {
        $this->namespace = 'contact/v1';
        $this->rest_base = 'index';
    }

    public function register_routes() {
        register_rest_route(
            $this-> namespace,
            '/' . $this->rest_base,
            [
                [
                    'methods'               => WP_REST_Server::READABLE,
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
                [
                    'methods'               => WP_REST_Server::EDITABLE,
                    'callback'              => [ $this, 'update_item' ],
                    'permission_callback'   => [  $this, 'update_item_permissions_check' ],
                    'args'                  => $this->get_endpoint_args_for_item_schema( WP_REST_Server::EDITABLE ),
                ],
                'schema' => [$this, 'get_item_schema' ],
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/(?P<id>[\d]+)',
            [
                'args'  => [
                    'id' => [
                        'description'   => __( 'Unique identifier for the object.' ),
                        'type'          => 'integer',
                    ],
                ],
                [
                    'methods'               => WP_REST_Server::EDITABLE,
                    'callback'              => [ $this, 'update_item' ],
                    'permission_callback'   => [ $this, 'update_item_permissions_check' ],
                    'args'                  => $this->get_endpoint_args_for_item_schema( WP_REST_Server::EDITABLE ),
                ],
                'schema' => [$this, 'get_item_schema' ],
            ]
        );
    }

    /**
     * Check if access to contacts
     * @param $request
     * @return true|void|\WP_Error
     */
    public function get_items_permissions_check( $request ){
        if ( current_user_can( 'manage_options' ) ) {
            return true;
        }

        return false;
    }

    /**
     * Retrieves a list of contacts
     * @param $request
     * @return \WP_Error|\WP_REST_Response
     */
    public function get_items($request)
    {
        $response = get_option( 'contact_option_column' );


        return $response;
    }

    /**
     * @return array|void
     */
    public function get_item_schema()
    {
        if ( $this->schema ) {
            return $this->add_additional_fields_schema( $this->schema
            );
        }

        $schema = [
            'schema'        => 'http://json-schema.org/draft-04/schema#',
            'title'         => 'contact',
            'type'          => 'object',
            'properties'    => [
                'id' => [
                    'description'   => __( 'Unique Identifies for the object' ),
                    'type'          => 'integer',
                    'context'       => [ 'view', 'edit' ],
                    'readonly'      => true,
                ],
                'name' => [
                    'description'   => __( 'Name for the object' ),
                    'type'          => 'string',
                    'context'       => [ 'view', 'edit' ],
                    'required'      => true,
                    'arg_options'   => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ]
                ],
                'email' => [
                    'description'   => __( 'E-mail for the object' ),
                    'type'          => 'string',
                    'context'       => [ 'view', 'edit' ],
                    'required'      => true,
                    'arg_options'   => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ]
                ],
                'address' => [
                    'description'   => __( 'Address for the object' ),
                    'type'          => 'string',
                    'context'       => [ 'view', 'edit' ],
                    'required'      => true,
                    'arg_options'   => [
                        'sanitize_callback' => 'sanitize_textarea_field',
                    ]
                ],
                'date' => [
                    'description'   => __( 'The date the object was published.' ),
                    'type'          => 'string',
                    'format'        => 'date-time',
                    'context'       => [ 'view' ],
                    'readonly'      => true,
                ],
            ]
        ];
        $this->schema = $schema;

        return $this->add_additional_fields_schema( $this->schema );
    }

    public function create_item_permissions_check($request)
    {
        return $this->get_items_permissions_check( $request );
    }

    public function create_item( $request ) {

        $contact = $this->prepare_item_for_database( $request );

        if ( empty( $contact['name'] ) ) {
            return new \WP_Error( 'no-name', __( 'You must provide a name', 'api_crud' ) );
        }

        $contact_info = wd_ac_insert_contact( $contact );

        if ( is_wp_error( $contact_info ) ) {
            $contact_info->add_data( [ 'status' => 400 ] );
            return $contact_info;
        }

        $response = $contact_info;

        return $response;
    }

    public function prepare_item_for_database( $request ) {
        $prepares = [];

        if ( isset( $request['name'] ) ) {
            $prepares['name'] = $request['name'];
        }

        if ( isset( $request['email'] ) ) {
            $prepares['email'] = $request['email'];
        }

        if ( isset( $request['address'] ) ) {
            $prepares['address'] = $request['address'];
        }

        return $prepares;
    }

    /**
     * Prepares the item for the REST response.
     *
     * @param mixed $item WordPress representation of the item.
     * @param \WP_REST_Request $request Request object.
     *
     * @return \WP_Error|WP_REST_Response
     */
    public function prepare_item_for_response( $item, $request ) {
        $data   = [];
        $fields = $this->get_fields_for_response( $request );

        if ( in_array( 'name', $fields, true ) ) {
            $data['name'] = $item->name;
        }

        if ( in_array( 'address', $fields, true ) ) {
            $data['address'] = $item->address;
        }

        if ( in_array( 'email', $fields, true ) ) {
            $data['email'] = $item->email;
        }

        if ( in_array( 'date', $fields, true ) ) {
            $data['date'] = mysql_to_rfc3339( $item->created_at );
        }

        $context = ! empty( $request['context'] ) ? $request['context'] : 'view';
        $data    = $this->filter_response_by_context( $data, $context );

        $response = rest_ensure_response( $data );
        $response->add_links( $this->prepare_links( $item ) );

        return $response;
    }

    /**
     * Check if a given request has the permission to update the item
     * @param \WP_REST_Request $request full data about the request
     * @return boolean|\WP_Error
     */
    public function update_item_permissions_check( $request )
    {
        if ( ! current_user_can( 'manage_options' ) ) {
            return false;
        }

        return true;
    }

    /**
     * Update the specific item
     * @param $request
     * @return void|\WP_Error|\WP_REST_Response
     */
    public function update_item( $request )
    {
        return $request;
    }

}