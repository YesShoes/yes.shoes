<?php
// Die if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

class FC_API_Connect {

    private $_key = '';
    private $_error = '';
    private $_endpoint = 'https://events.justbookitnow.com/api/v1';

    public function __construct( $key ) {
        $this->_key = $key;
    }

    function listPackages( $size = 100, $page = 1 ) {
        $url     = $this->buildUrl( 'packages', 'list', [ 'pagesize' => $size, 'page' => $page ] );
        $options = $this->buildRequestOptions( $this->_key );
        $request = wp_safe_remote_post( $url, $options );
        if ( is_wp_error( $request ) ) {
            $this->_error = $request->get_error_message();

            return $this->_error;
        } else {
            $result = $this->processResponse( $request );
        }

        return $result;
    }

    function listTicket( $package_id, $url = 'https://events.justbookitnow.com/api/v1/packages/tickets' ) {
        $url      = $url . '/package/' . $package_id;
        $ch       = curl_init( $url );
        $header   = [];
        $header[] = 'Accept: application/json';
        $header[] = 'Accept-Language: en-GB';
        $header[] = 'X-FS-Token: ' . $this->_key;
        $post     = [
            (object) [ 'package' => $package_id ],
        ];
        $post     = json_encode( $post );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        //    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query(array('package'=>$post)));
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
        $result = curl_exec( $ch );
        curl_close( $ch );
        if ( $result == false ) {
            $this->_error = curl_error( $ch );

            return false;
        }

        return json_decode( $result );
    }

    function buildUrl( $base, $type, $args = [] ) {
        $url = $this->_endpoint . '/' . $base . '/' . $type;
        if ( ! empty( $args ) ) {
            foreach ( $args as $option => $value ) {
                $url .= '/' . $option . '/' . $value;
            }
        }
        $url .= '/';

        return $url;
    }

    function buildRequestOptions( $key ) {
        $args = [
            'headers'     => [
                'Accept'          => 'application/json',
                'Accept-Language' => 'en-GB',
                'X-FS-Token'      => $key
            ],
            'httpversion' => '1.0',
            'timeout'     => 100,
            'redirection' => 3,
            'user-agent'  => 'roccr.com',
            'blocking'    => true,
            'compress'    => true,
            'decompress'  => true,
            'sslverify '  => true
        ];

        return $args;
    }

    function processResponse( $response ) {
        $response_code = wp_remote_retrieve_response_code( $response );
        if ( $response_code == '200' ) {
            $body   = wp_remote_retrieve_body( $response );
            $filter = json_decode( $body, true );
            $data   = [
                'info'   => $filter['data'],
                'status' => true
            ];
        } else {
            $data = [
                'info'   => wp_remote_retrieve_response_message( $response ),
                'status' => false
            ];
        }

        return $data;
    }
}