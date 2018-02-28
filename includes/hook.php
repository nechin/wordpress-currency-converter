<?php
/**
 * Created by Alexander Vitkalov
 * User: Alexander Vitkalov
 * Date: 05.09.2017
 * Time: 09:10
 */

/**
 * The hook handler
 *
 * Class Vav_Converter_Hook
 */
class Vav_Converter_Hook extends Vav_Converter_DB {
    /**
     * Constructor
     */
    function __construct() {
		parent::__construct();
    }

	/**
	 * Activation plugin
	 */
	public function activation() {
		$tables = $this->get_tables();
		foreach ( $tables as $table_name => $table_sql ) {
			if ( $this->db->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name ) {
				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
				dbDelta( $table_sql );
			}
		}
	}

	/**
	 * Uninstall plugin
	 */
	public function uninstall() {
		Vav_Converter_Hook::drop_tables();
	}

    /**
     * Initialization
     */
    public function init() {
        define( 'VAV_URL', plugin_dir_url( VAV_PATH ) );
    }

    /**
     * Enqueue scripts
     */
    public function enqueue_scripts() {
        wp_enqueue_style( 'vav-converter', VAV_URL . 'public/css/style.css' );
        wp_enqueue_script( 'vav-converter', VAV_URL . 'public/js/script.js', ['jquery'], false, true );
        $translation_array = [
            'admin_ajax_url' => admin_url( 'admin-ajax.php' ),
            'text' => [
	            'empty_field_sum' => str_replace( '%s', __( 'Sum', 'converter' ),  __( "The value of the '%s' field can not be empty", 'converter' ) ),
	            'wrong_field_sum' => str_replace( '%s', __( 'Sum', 'converter' ),  __( "The value of the '%s' field must be a number", 'converter' ) ),
            ]
        ];
        wp_localize_script( 'vav-converter', 'vav_data', $translation_array );
    }

    /**
     * Enqueue admin scripts
     */
    public function admin_enqueue_scripts() {
    	wp_enqueue_script( 'thickbox' );
	    wp_enqueue_style( 'thickbox' );

        wp_enqueue_style( 'vav-converter', VAV_URL . 'admin/css/style.css' );
        wp_enqueue_script( 'vav-converter', VAV_URL . 'admin/js/script.js', ['jquery'], false, true );
        $translation_array = [
            'admin_ajax_url' => admin_url( 'admin-ajax.php' ),
	        'text' => [
	        	'empty_field_name' => str_replace( '%s', __( 'Name', 'converter' ),  __( "The value of the '%s' field can not be empty", 'converter' ) ),
	        	'empty_field_rate' => str_replace( '%s', __( 'Rate', 'converter' ),  __( "The value of the '%s' field can not be empty", 'converter' ) ),
	        	'wrong_field_rate' => str_replace( '%s', __( 'Rate', 'converter' ),  __( "The value of the '%s' field must be a number", 'converter' ) ),
	        	'confirm_delete' => __( "Are you sure you want to delete the currency '%s'?", 'converter' ),
	        ]
        ];
        wp_localize_script( 'vav-converter', 'vav_data', $translation_array );
    }

	/**
	 * Internationalization
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'converter', FALSE, basename( VAV_DIR ) . '/languages/' );
	}

}
