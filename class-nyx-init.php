<?php


class Nyx_Init
{
    /**
     * Allows for updating database.
     * @var int
     */
    private static $db_version = 1;

    public static function init()
    {

        add_action( 'init', array( self::class, 'register_cp' ) );
        add_action( 'admin_enqueue_scripts', array( self::class, 'load_admin_assets' ) );
        add_action( 'admin_enqueue_scripts', array( self::class, 'load_assets' ) );
        add_action( 'wp_enqueue_scripts', array( self::class, 'load_assets' ) );
        add_action( 'add_meta_boxes', array( self::class, 'add_meta_boxes' ) );
        add_action( 'save_post', array( self::class, 'save_meta_box_data' ) );

        add_filter( 'manage_edit-ticket-areas_columns', array( self::class, 'add_ticket_area_columns' ) );
        add_action( 'manage_ticket-areas_posts_custom_column', array( self::class, 'fill_ticket_area_columns' ), 10, 2 );
        add_action( 'admin_menu', array( self::class, 'add_settings_sub_menu' ) );

        add_action( 'wp_ajax_nyx_ticket_view', array( self::class, 'nyx_ticket_view' ) );
        add_action( 'wp_ajax_nopriv_nyx_ticket_view', array( self::class, 'nyx_ticket_view' ) );

        add_action( 'wp_head', array( self::class, 'add_to_theme_header' ) );

        add_shortcode( 'nyx-ticket', array( self::class, 'nyx_ticket' ) );
    }

    /**
     * Registers our custom ticket area post type.
     */
    public static function register_cp()
    {

        register_post_type( 'ticket-areas',

            array(
                'labels'       => array(
                    'name'          => __( 'Nyx tickets' ),
                    'singular_name' => __( 'Nyx tickets' )
                ),
                'public'       => true,
                'has_archive'  => true,
                'rewrite'      => array( 'slug' => 'ticket-areas' ),
                'show_in_rest' => true,
                'supports'     => array( 'title' ),
                'menu_icon'    => 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNy44OSAyNS44Ij4KICA8ZGVmcz4KICAgIDxzdHlsZT4uY2xzLTF7ZmlsbDojMDBkNmQ4O30uY2xzLTJ7ZmlsbDojZjBmMWYzO308L3N0eWxlPgogIDwvZGVmcz4KICA8dGl0bGU+bnl4X2xvZ288L3RpdGxlPgogIDxnIGlkPSJMYXllcl8yIiBkYXRhLW5hbWU9IkxheWVyIDIiPgogICAgPGcgaWQ9IkxheWVyXzEtMiIgZGF0YS1uYW1lPSJMYXllciAxIj4KICAgICAgPHBvbHlnb24gY2xhc3M9ImNscy0xIiBwb2ludHM9IjMuMjcgMjEuMzQgMy4yNyAyNS44IDI0LjYyIDQuNDggMjQuNjIgMCAzLjI3IDIxLjM0Ii8+CiAgICAgIDxwb2x5Z29uIGNsYXNzPSJjbHMtMiIKICAgICAgICAgICAgICAgcG9pbnRzPSIyNC42MiAwIDI0LjYyIDIxLjM0IDMuMjcgMCAwIDAgMCAyNS44IDMuMjcgMjUuOCAzLjI3IDQuNDggMjQuNjIgMjUuOCAyNy44OSAyNS44IDI3Ljg5IDAgMjQuNjIgMCIvPgogICAgPC9nPgogIDwvZz4KPC9zdmc+Cg=='
            )

        );

    }

    /**
     * Adds content to the theme header.
     */
    public static function add_to_theme_header()
    {
        echo '<script type="text/javascript">
           var ajaxurl = "' . esc_url( admin_url( 'admin-ajax.php' ) ) . '";
         </script>';
    }

    /**
     * Add settings submenu point.
     */
    public static function add_settings_sub_menu()
    {
        add_submenu_page( 'edit.php?post_type=ticket-areas', "Nyx settings", "Nyx settings", 'manage_options', 'nyx-settings', function () {
            Nyx_View::view( 'admin-settings' );
        } );
    }

    /**
     * Load all assets that is only available for admins.
     */
    public static function load_admin_assets()
    {
        wp_register_script( 'nyx-vendor-spectrum', plugin_dir_url( __FILE__ ) . 'assets/vendor/spectrum.js', array(), false, true );
        wp_enqueue_script( 'nyx-vendor-spectrum' );

        wp_register_script( 'nyx-vendor-swal', plugin_dir_url( __FILE__ ) . 'assets/vendor/swal.js', array(), false, true );
        wp_enqueue_script( 'nyx-vendor-swal' );

    }

    /**
     * Load assets for frontend.
     */
    public static function load_assets()
    {

        wp_register_style( 'nyx-vendor-spectrum.css', plugin_dir_url( __FILE__ ) . 'assets/vendor/spectrum.css', array() );
        wp_enqueue_style( 'nyx-vendor-spectrum.css' );

        wp_register_style( 'nyx-ticket.css', plugin_dir_url( __FILE__ ) . 'assets/nyx-ticket.css', array( 'nyx-vendor-spectrum.css' ), '2' );
        wp_enqueue_style( 'nyx-ticket.css' );


        wp_enqueue_script( 'nyx-admin-script', plugin_dir_url( __FILE__ ) . 'assets/nyx-admin-script.js', array( 'nyx-vendor-spectrum', 'nyx-vendor-swal' ), false, true );
        wp_enqueue_script( 'nyx-frontend-script', plugin_dir_url( __FILE__ ) . 'assets/nyx-frontend-script.js', array( 'jquery' ), false, true );
    }

    /**
     * Returns the frontend event list view.
     */
    public static function nyx_ticket_view()
    {

        global $wpdb;

        $post = get_post( sanitize_text_field( $_REQUEST['post'] ) ); //Fetch ticket post

        $table = $wpdb->prefix . 'nyx_ticket_events';

        //Get all events
        $events = ( new Nyx_Api() )->set_api_key( get_option( 'nyx-api-key' ) )->ticket_events()->getBody();

        if ( isset($events->error_code) ) //If there is an error code set events to empty
            $events = [];

        //Get post meta settings for currenct ticket area
        $post_settings = array(
            'nyx-box-bg-single-event-color'                => get_post_meta( $post->ID, 'nyx-box-bg-single-event-color', true ),
            'nyx-box-border-single-event-color'            => get_post_meta( $post->ID, 'nyx-box-border-single-event-color', true ),
            'nyx-box-single-event-txt-color'               => get_post_meta( $post->ID, 'nyx-box-single-event-txt-color', true ),
            'nyx-box-single-event-border-radius'           => get_post_meta( $post->ID, 'nyx-box-single-event-border-radius', true ),
            'nyx-box-single-event-btn-color'               => get_post_meta( $post->ID, 'nyx-box-single-event-btn-color', true ),
            'nyx-box-bg-single-btn-border-color'           => get_post_meta( $post->ID, 'nyx-box-bg-single-btn-border-color', true ),
            'nyx-box-border-single-event-btn-txt-color'    => get_post_meta( $post->ID, 'nyx-box-border-single-event-btn-txt-color', true ),
            'nyx-box-single-event-btn-border-radius'       => get_post_meta( $post->ID, 'nyx-box-single-event-btn-border-radius', true ),
            'nyx-box-border-single-event-circle-color'     => get_post_meta( $post->ID, 'nyx-box-border-single-event-circle-color', true ),
            'nyx-box-single-event-ticket-btn-standard-txt' => get_post_meta( $post->ID, 'nyx-box-single-event-ticket-btn-standard-txt', true ),
        );

        ob_start();

        $view = sanitize_text_field( $_REQUEST['view'] );

        if ( $view == 'compact' ) {
            Nyx_View::view( 'compact-list-view', compact( 'post', 'events', 'post_settings' ) );
        } else {
            Nyx_View::view( 'full-list-view', compact( 'post', 'events', 'post_settings' ) );
        }

        echo ob_get_clean();

        wp_die();
    }


    /**
     * Makes shortcode available for use.
     * @param $atts
     * @return false|string
     */
    public static function nyx_ticket( $atts )
    {
        $post = get_post( $atts['area'] );
        $view = get_post_meta( $post->ID, 'nyx-box-style', true ); //Get the view, compact or full.

        ob_start();
        Nyx_View::view( 'shortcode-content', compact( 'post', 'view' ) );

        return ob_get_clean();
    }

    /**
     * Add a new column to the ticket area post type.
     * @param $columns
     * @return mixed
     */
    public static function add_ticket_area_columns( $columns )
    {

        $columns['shortcode'] = __( 'Shortcode', 'nyx-ticket' );

        return $columns;
    }

    /**
     * Fills new area on post type - ticket area.
     * @param $column
     * @param $post_id
     */
    public static function fill_ticket_area_columns( $column, $post_id )
    {
        global $post;

        if ( $column == 'shortcode' ) {
            echo esc_html( '[nyx-ticket area="' . $post_id . '"]' );
        }
    }

    /**
     * Adds a meta box on ticket area post types.
     */
    public static function add_meta_boxes()
    {

        add_meta_box(
            'ticket-areas',
            __( 'NYX', 'nyx-ticket' ),
            function ( $post ) {
                Nyx_View::view( 'admin-boxes', compact( 'post' ) );
            },
            'ticket-areas'
        );

    }

    /**
     * When the post is saved, saves our custom data.
     *
     * @param int $post_id
     */
    public static function save_meta_box_data( $post_id )
    {

        // Check if our nonce is set.
        if ( !isset( $_POST['ticket_area_nonce'] ) ) {
            return;
        }

        // Verify that the nonce is valid.
        if ( !wp_verify_nonce( $_POST['ticket_area_nonce'], 'ticket_area_nonce' ) ) {
            return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        // Check the user's permissions.
        if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

            if ( !current_user_can( 'edit_page', $post_id ) ) {
                return;
            }

        } else {

            if ( !current_user_can( 'edit_post', $post_id ) ) {
                return;
            }
        }

        /* OK, it's safe for us to save the data now. */

        // Make sure that it is set.
        if ( !isset( $_POST['nyx-box'] ) ) {
            return;
        }

        //Loop over all settings.
        foreach ( $_POST['nyx-box'] as $section => $value ) {

            // Sanitize user input.
            $value = sanitize_text_field( $value );

            // Update the meta field in the database.
            update_post_meta( $post_id, 'nyx-box-' . $section, $value );

        }

    }

    /**
     * Cleans up on plugin uninstall
     */
    public function uninstall()
    {
        delete_option( 'nyx-db-version' );
        delete_option( 'nyx-api-key' );
    }
}