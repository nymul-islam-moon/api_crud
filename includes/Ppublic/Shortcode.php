<?php

namespace Api\Crud\Ppublic;

/**
 * Shortcode handler class
 */
class Shortcode {

    /**
     * Initializes the class
     */
    public function __construct() {
        add_shortcode( 'api_crud', [ $this, 'render_shortcode' ] );
    }

    /**
     * Shortcode handler class
     *
     * @param array $attr
     * @param string $content
     * @return string
     */
    public function render_shortcode( $attr, $content = '' ){
        return 'Hello From Shortcode';
    }
}