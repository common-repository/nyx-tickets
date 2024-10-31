<?php

class Nyx_Api
{

    private $base = "https://customer.nyxapp.net/api/public/";

    private $request;

    private $headers = array( 'headers' => array( 'X-Nyx-API-Token' => '' ) );

    public function init()
    {

        if ( is_admin() === true ) {
            add_action( 'wp_ajax_nyx_fetch_data', array( $this, 'nyx_fetch_data' ) );
        }

    }

    public function getResponse()
    {
        return $this->request['response'];
    }

    public function getBody()
    {
        return json_decode( $this->request['body'] );
    }

    /**
     * Do a WordPress get request.
     * @param $end_point
     * @return $this
     */
    private function get( $end_point )
    {
        $this->request = wp_remote_get( $this->base . $end_point, $this->headers );

        return $this;
    }

    public function set_api_key( $key = null )
    {
        $key = $key ?? get_option( 'nyx-api-key' );

        $this->headers['headers']['X-Nyx-API-Token'] = $key;

        return $this;
    }

    public function ticket_events()
    {
        $this->get( 'ticket_events?date_from='.date('Y-m-d') );

        return $this;
    }

    /**
     * Fetch data once user fills in their API key,
     */
    public function nyx_fetch_data()
    {
        global $wpdb;

        //If options is already in DB then update, otherwise add.
        if ( isset( $_POST['nyx-api-key'] ) ) {

            $api_key = sanitize_text_field( $_POST['nyx-api-key'] );

            if ( get_option( 'nyx-api-key' ) !== false ) {
                update_option( 'nyx-api-key', $api_key );
            } else {
                add_option( 'nyx-api-key', $api_key );
            }

            $this->set_api_key( $api_key );
        }


        if ( $this->ticket_events()->getResponse()['code'] == 200 ) {
            echo 200;
        } else {
            echo esc_attr( $this->getResponse()['code'] );
        }


        wp_die();

    }

}