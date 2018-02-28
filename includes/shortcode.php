<?php

/**
 * Created by Alexander Vitkalov
 * User: Alexander Vitkalov
 * Date: 05.09.2017
 * Time: 13:44
 */

/**
 * Shortcode manager
 *
 * Class Vav_Converter_Shortcode
 */
class Vav_Converter_Shortcode {

	/**
	 * Initialization shortcodes
	 */
	public function init() {
		add_shortcode('vav_convertor', [ $this, 'render_calculator' ] );
	}

	/**
	 * Render calculator
	 *
	 * @param array $atts
	 * @param null $content
	 *
	 * @return null
	 */
	public function render_calculator( $atts = [], $content = null ) {
		global $vav_converter;

		return $vav_converter->manager->get_content( VAV_TPL_DIR . '/public/calculator.tpl.php' );
	}

}