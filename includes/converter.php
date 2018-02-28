<?php
/**
 * Created by Alexander Vitkalov
 * User: Alexander Vitkalov
 * Date: 05.09.2017
 * Time: 09:09
 */

/**
 * Converter
 *
 * Class Vav_Converter
 */
class Vav_Converter {

    /**
     * @var null
     */
    protected static $_instance = null;

    /**
     * @var null
     */
    public $hook = null;

    /**
     * @var null
     */
    public $manager = null;

    /**
     * @var null
     */
    public $shortcode = null;

    /**
     * Constructor
     */
    function __construct() {
        $this->includes();

        $this->hook = new Vav_Converter_Hook();
        $this->manager = new Vav_Converter_Manager();
        $this->shortcode = new Vav_Converter_Shortcode();
    }

    /**
     * @return null|vav_converter
     */
    public static function instance() {
        if ( is_null ( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Include files
     */
    private function includes() {
        include_once ( VAV_DIR . '/includes/db.php' );
        include_once ( VAV_DIR . '/includes/hook.php' );
        include_once ( VAV_DIR . '/includes/manager.php' );
        include_once ( VAV_DIR . '/includes/shortcode.php' );
    }

    /**
     * Initialization
     */
    public function init() {
	    register_activation_hook( VAV_PATH, [ $this->hook, 'activation' ] );
	    register_uninstall_hook( VAV_PATH, [ 'Vav_Converter_Hook', 'uninstall' ] );

        add_action( 'init', [ $this->hook, 'init' ] );
        add_action( 'wp_enqueue_scripts', [ $this->hook, 'enqueue_scripts' ] );
        add_action( 'admin_enqueue_scripts', [ $this->hook, 'admin_enqueue_scripts' ] );
	    add_action( 'plugins_loaded',  [ $this->hook, 'load_plugin_textdomain' ] );

	    add_action( 'admin_menu', [ $this->manager, 'admin_menu' ] );
	    add_action( 'wp_ajax_vav_save_currency', [ $this->manager, 'ajax_save_currency' ] );
	    add_action( 'wp_ajax_vav_delete_currency', [ $this->manager, 'ajax_delete_currency' ] );
	    add_action( 'wp_ajax_vav_calculate', [ $this->manager, 'ajax_calculate' ] );
	    add_action( 'wp_ajax_nopriv_vav_calculate', [ $this->manager, 'ajax_calculate' ] );

	    add_action( 'init', [ $this->shortcode, 'init' ] );
    }

} 