<?php

/**
 * Created by Alexander Vitkalov
 * User: Alexander Vitkalov
 * Date: 05.09.2017
 * Time: 11:00
 */

/**
 * Currency Manager
 * 
 * Class Vav_Converter_Manager
 */
class Vav_Converter_Manager extends Vav_Converter_DB {
	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct();
	}

	/**
	 * Check unique name
	 *
	 * @param $id
	 * @param $name
	 *
	 * @return bool
	 */
	public function is_unique_name( $id, $name ) {
		$query = "SELECT id FROM " . $this->gt( 'currency' ) . " WHERE name = '%s' AND id <> '%s'";

		if ( ! $this->db->get_var( $this->db->prepare( $query, $name, $id ) ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Ajax save currency
	 */
	public function ajax_save_currency() {
		$succes = false;
		$result = __( 'Failed to save data', 'converter' );

		if ( isset( $_POST[ 'id' ] ) ) {
			$id   = intval( $_POST[ 'id' ] );
			$name = trim( $_POST[ 'name' ] );
			$rate = floatval( $_POST[ 'rate' ] );

			try {
				if ( $this->is_unique_name( $id, $name ) ) {
					if ( $id ) {
						$this->db->update(
							$this->gt( 'currency' ),
							[ 'name' => $name, 'rate' => $rate ],
							[ 'id' => $id ]
						);

						$succes = true;
					}
					else {
						$this->db->insert(
							$this->gt( 'currency' ),
							[ 'name' => $name, 'rate' => $rate ]
						);

						if ( $this->db->insert_id ) {
							$succes = true;
						}
					}
				}
				else {
					$result = __( 'Currency with this name already exists', 'converter' );
				}
			}
			catch (Exception $e) {
				$result = $e->getMessage();
			}
		}

		exit( json_encode( [
			'success' => $succes,
			'result' => $result,
		] ) );
	}

	/**
	 * Ajax delete currency
	 */
	public function ajax_delete_currency() {
		$succes = false;
		$result = __( 'Failed to delete data', 'converter' );

		if ( isset( $_POST[ 'id' ] ) ) {
			$id = intval( $_POST[ 'id' ] );

			try {
				$this->db->delete(
					$this->gt( 'currency' ),
					[ 'id' => $id ]
				);

				$succes = true;
			}
			catch (Exception $e) {
				$result = $e->getMessage();
			}
		}

		exit( json_encode( [
			'success' => $succes,
			'result' => $result,
		] ) );
	}

	/**
	 * Ajax calculate
	 */
	public function ajax_calculate(  ) {
		$succes = false;
		$result = __( 'Calculate failed', 'converter' );

		if ( isset( $_POST[ 'sum' ] ) ) {
			$sum  = floatval( $_POST[ 'sum' ] );
			$from = intval( $_POST[ 'from' ] );
			$to   = intval( $_POST[ 'to' ] );

			try {
				$from_rate = $this->db->get_var( $this->db->prepare(
					"SELECT rate FROM " . $this->gt( 'currency' ) . " WHERE id = '%s'", $from
				));
				$to_rate = $this->db->get_var( $this->db->prepare(
					"SELECT rate FROM " . $this->gt( 'currency' ) . " WHERE id = '%s'", $to
				));
				$result = round($sum * $from_rate / $to_rate, 2);

				$succes = true;
			}
			catch (Exception $e) {
				$result = $e->getMessage();
			}
		}

		exit( json_encode( [
			'success' => $succes,
			'result' => $result,
		] ) );
	}

	/**
	 * Get currencies
	 *
	 * @return array
	 */
	public function get_currencies() {
		$currencies = [];

		$results = $this->db->get_results( "
            SELECT * FROM " . $this->gt( 'currency' ) .  " ORDER BY name
        " );
		if ($results) {
			foreach ($results as $result) {
				$currencies[] = [
					'id' => $result->id,
					'name' => $result->name,
					'rate' => $result->rate
				];
			}
		}

		return $currencies;
	}

	/**
	 * Get content
	 *
	 * @param $template_file_path
	 *
	 * @return string
	 */
	public function get_content( $template_file_path ) {
		try {
			if ( file_exists( $template_file_path ) ) {
				ob_start();
				include $template_file_path;
				$content = ob_get_contents();
				ob_end_clean();
			}
			else {
				$content = "<p>" . printf( __( "Template '%s' not found", 'converter' ), $template_file_path ) . "</p>";
			}
		}
		catch (Exception $e) {
			$content = "<p>" . printf( __( "Template '%s' not found", 'converter' ), $template_file_path ) . "</p>";
			$content .= "<p>" . $e->getMessage() . "</p>";
		}

		return $content;
	}

	/**
	 * Render admin manager page
	 */
	public function admin_page() {
		echo $this->get_content( VAV_TPL_DIR . '/admin/manager.tpl.php' );
	}

	/**
	 * Admin menu
	 */
	public function admin_menu() {
		add_menu_page(
			__( 'Currency calculator', 'converter' ),
			__( 'Currency calculator', 'converter' ),
			'manage_options',
			'vav-converter',
			[ $this, 'admin_page' ],
			VAV_URL . '/admin/images/calc.png',
			50
		);
	}

}