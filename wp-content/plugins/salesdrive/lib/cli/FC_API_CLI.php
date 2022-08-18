<?php
// Die if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

class FC_API_CLI extends WP_CLI_Command {
    /**
     * Command for feed orders from http://events.justbookitnow.com
     * ## OPTIONS
     *
     * [--per-chunk=<per-chunk>]
     * : The amount of orders into chunk per one project, grater value for speed servers.
     * ---
     * default: 200
     * ---
     *
     * [--fast=<full>]
     * : Whether or not to run fast import, means copy all orders without checks for previously imported(hard rewrite)
     * ---
     * default: no
     * options:
     *   - no
     *   - yes
     * ---
     *
     * @when after_wp_load
     */
    function feed( $args, $assoc_args ) {

        WP_CLI::line( WP_CLI::colorize( '%GFeed start...%N' ) );
        $for_request = intval( $assoc_args['per-chunk'] );
        $full        = $assoc_args['full'];
        if ( empty( $for_request ) ) {
            $for_request = 200;
        }
        $response = $this->run_feed_process( $for_request );
        $fields   = [ 'TOTAL', 'NEW/UPDATED', 'DUPLICATES', 'FAIL' ];
        $items    = [];
        array_push( $items, $response );
        WP_CLI\Utils\format_items( 'table', $items, $fields );
        if ( $full === 'yes' ) {
            WP_CLI::success( 'Import finished running.' );
            WP_CLI::runcommand( 'events clean --full=yes --per-chunk=' . $per_request, [ 'launch' => true ] );
        }
        WP_CLI::success( 'Script finished running.' );

    }

    private function run_feed_process( $chunk ) {

    }
}

WP_CLI::add_command( 'fcapi', 'FC_API_CLI' );