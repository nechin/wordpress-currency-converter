<?php
/**
 * Plugin Name: Converter
 * Description: Currency calculator - plugin for calculating exchange rates
 * Version: 1.0.0
 * Author: Alexander Vitkalov
 * Author URI: http://vitkalov.ru
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: vav-converter
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! class_exists( 'Vav_Converter' ) ) {
    define( 'VAV_PATH', __FILE__ );
    define( 'VAV_DIR', dirname( __FILE__ ) );
    define( 'VAV_TPL_DIR', VAV_DIR . '/templates' );

    include_once ( VAV_DIR . '/includes/converter.php' );
}

$vav_converter = Vav_Converter::instance();
$vav_converter->init();