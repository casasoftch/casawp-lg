<?php

namespace casasoft\casawplg;

class general_options extends Feature
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
        add_action( 'admin_menu', array( $this, 'set_standard_terms' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'load_external_scripts' ) );


    }

    public function load_external_scripts(){
         wp_register_script('casawp-lg-options', PLUGIN_URL . 'assets/js/casawp-lg-options.js',  array('jquery') );

        wp_enqueue_media();
        //wp_enqueue_script('media-upload');
        wp_enqueue_script('casawp-lg-options');

    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin',
            __( 'CASAWP LG Settings', 'casawplg' ),
            'manage_options',
            'casawplg-admin',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {

        // Set class property
        $this->options = get_option( 'casawp_lg' );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>CASAWP Lead Generator</h2>
            <form method="post" action="options.php">
                <?php
                    // This prints out all hidden setting fields
                    settings_fields( 'clg_general_options' );
                    do_settings_sections( 'casawp-lg-admin' );
                    submit_button();
                ?>

                <button class="button button-default" type="submit" name="generate_defaults" value="true">Regenerate Default Terms</button>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'clg_general_options', // Option group
            'casawp_lg', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'clg_1', // ID
            __( 'Main Settings', 'casawplg' ), // Title
            array( $this, 'print_section_info' ), // Callback
            'casawp-lg-admin' // Page
        );

/*
        add_settings_field(
            'emails',
             __( 'Emails', 'casawplg' ),
            array( $this, 'emails_callback' ),
            'casawp-lg-admin',
            'clg_1'
        );*/

        add_settings_field(
            'iazikey_url',
             __( '<strong>IAZI</strong><span style="font-weight:100">evaluation</span> URL', 'casawplg' ),
            array( $this, 'iazikey_url_callback' ),
            'casawp-lg-admin',
            'clg_1'
        );

        add_settings_field(
            'iazievaluation_key',
             __( '<strong>IAZI</strong><span style="font-weight:100">evaluation</span> Key', 'casawplg' ),
            array( $this, 'iazievaluation_key_callback' ),
            'casawp-lg-admin',
            'clg_1'
        );

        add_settings_field(
            'global_direct_recipient_email',
             __( '<strong>CASA</strong><span style="font-weight:100">MAIL</span> direkte E-Mail', 'casawplg' ),
            array( $this, 'global_direct_recipient_email_callback' ),
            'casawp-lg-admin',
            'clg_1'
        );

        add_settings_field(
            'provider_slug',
             __( '<strong>CASA</strong><span style="font-weight:100">MAIL</span> Provider ID', 'casawplg' ),
            array( $this, 'provider_slug_callback' ),
            'casawp-lg-admin',
            'clg_1'
        );

        add_settings_field(
            'publisher_slug',
             __( '<strong>CASA</strong><span style="font-weight:100">MAIL</span> Publisher ID', 'casawplg' ),
            array( $this, 'publisher_slug_callback' ),
            'casawp-lg-admin',
            'clg_1'
        );

/*
        add_settings_field(
            'remcat',
             __( 'Remcat', 'casawplg' ),
            array( $this, 'remcat_callback' ),
            'casawp-lg-admin',
            'clg_1'
        );*/


    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {

        $new_input = array();
        if( isset( $input['id_number'] ) ) {
            $new_input['id_number'] = absint( $input['id_number'] );
        }

        if( isset( $input['iazikey_url'] ) ) {
            $new_input['iazikey_url'] = sanitize_text_field( $input['iazikey_url'] );
        }

        if( isset( $input['iazievaluation_key'] ) ) {
            $new_input['iazievaluation_key'] = sanitize_text_field( $input['iazievaluation_key'] );
        }

        if( isset( $input['global_direct_recipient_email'] ) ) {
            $new_input['global_direct_recipient_email'] = sanitize_text_field( $input['global_direct_recipient_email'] );
        }

        if( isset( $input['provider_slug'] ) ) {
            $new_input['provider_slug'] = sanitize_text_field( $input['provider_slug'] );
        }

        if( isset( $input['publisher_slug'] ) ) {
            $new_input['publisher_slug'] = sanitize_text_field( $input['publisher_slug'] );
        }

       /* if( isset( $input['remcat'] ) ) {
            $new_input['remcat'] = sanitize_text_field( $input['remcat'] );
        }*/


        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print __( 'Enter your settings below:', 'casawplg' ); // Title;
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function id_number_callback()
    {
        printf(
            '<input type="text" id="id_number" name="casawp_lg[id_number]" value="%s" />',
            isset( $this->options['id_number'] ) ? esc_attr( $this->options['id_number']) : ''
        );
    }

    public function iazikey_url_callback()
    {
        printf(
            '<input type="text" id="iazikey_url" name="casawp_lg[iazikey_url]" value="%s" />',
            isset( $this->options['iazikey_url'] ) ? esc_attr( $this->options['iazikey_url']) : ''
        );
    }

    public function iazievaluation_key_callback()
    {
        printf(
            '<input type="text" id="iazievaluation_key" name="casawp_lg[iazievaluation_key]" value="%s" />',
            isset( $this->options['iazievaluation_key'] ) ? esc_attr( $this->options['iazievaluation_key']) : ''
        );
    }

    public function global_direct_recipient_email_callback()
    {
        printf(
            '<input type="text" id="global_direct_recipient_email" name="casawp_lg[global_direct_recipient_email]" value="%s" />',
            isset( $this->options['global_direct_recipient_email'] ) ? esc_attr( $this->options['global_direct_recipient_email']) : ''
        );
    }

    public function provider_slug_callback()
    {
        printf(
            '<input type="text" id="provider_slug" name="casawp_lg[provider_slug]" value="%s" />',
            isset( $this->options['provider_slug'] ) ? esc_attr( $this->options['provider_slug']) : ''
        );
    }

    public function publisher_slug_callback()
    {
        printf(
            '<input type="text" id="publisher_slug" name="casawp_lg[publisher_slug]" value="%s" />',
            isset( $this->options['publisher_slug'] ) ? esc_attr( $this->options['publisher_slug']) : ''
        );
    }


   /* public function remcat_callback()
    {
        printf(
            '<input type="text" id="remcat" name="casawp_lg[remcat]" value="%s" />',
            isset( $this->options['remcat'] ) ? esc_attr( $this->options['remcat']) : ''
        );
    }*/
    


    public function set_standard_terms(){
        if (isset($_GET['generate_defaults']) || isset($_POST['generate_defaults'])) {
            wp_insert_term( 'Suchmaschinen', 'inquiry_reason', $args = array() );
            wp_insert_term( 'Immobilienplattform', 'inquiry_reason', $args = array() );
            wp_insert_term( 'Events / Anzeigen', 'inquiry_reason', $args = array() );
            wp_insert_term( 'Persönlich vorgeschlagen', 'inquiry_reason', $args = array() );
        }
    }
}

add_action( 'casawplg_init', array( 'casasoft\casawplg\general_options', 'init' ) );
