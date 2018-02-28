<?php

/**
 * Created by Alexander Vitkalov
 * User: Alexander Vitkalov
 * Date: 05.09.2017
 * Time: 12:28
 */

/**
 * DB
 *
 * Class Vav_Converter_DB
 */
class Vav_Converter_DB {
	/**
	 * @var null
	 */
	protected $db = null;

	/**
	 * Constructor
	 */
	function __construct() {
		global $wpdb;

		$this->db = $wpdb;
	}

	/**
	 * Return prefix
	 *
	 * @return mixed
	 */
	private function get_prefix() {
		global $wpdb;

		return $wpdb->prefix;
	}

	/**
	 * Drop tables
	 */
	static function drop_tables() {
		global $wpdb;

		$tables = self::get_tables();
		foreach ( $tables as $table_name => $table_sql ) {
			$sql = "DROP TABLE IF EXISTS ". $table_name . ";";
			$wpdb->query( $sql );
		}
	}

	/**
	 * Table name
	 *
	 * @param $name
	 * @return string
	 */
	public function gt( $name ) {
		$table_names = array(
			'currency' => self::get_prefix() . 'vav_converter_currency'
		);

		if ( isset( $table_names ) ) {
			return $table_names[ $name ];
		}

		return '';
	}

	/**
	 * Return tables
	 *
	 * @return array
	 */
	public function get_tables() {
		$tables = array(
			self::gt( 'currency' ) => "
            CREATE TABLE IF NOT EXISTS " . self::gt( 'currency' ) . " (
                id INT(11) NOT NULL AUTO_INCREMENT,
                name varchar(255) NOT NULL,
                rate float(24) NOT NULL,
                PRIMARY KEY  (id)
            )
            ENGINE = INNODB
            CHARACTER SET " . DB_CHARSET . "
            COLLATE utf8mb4_unicode_ci;"
		);

		return $tables;
	}
}