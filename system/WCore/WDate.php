<?php
/**
 * WDatabase.php
 */

defined('IN_WITY') or die('Access denied');

/**
 * WDate manages dates using the user's custom timezone
 *
 * @package System\WCore
 * @author Johan Dufau <johan.dufau@creatiwity.net>
 * @version 0.4-24-09-2013
 */
class WDate extends DateTime {
	/**
	 * This function handles user's custom timezone
	 * 
	 * @param string If empty, use the current date. See DateTime class for full documentation.
	 */
	public function __construct($date = '') {
		// Finally build the date
		parent::__construct($date, $this->getUserTimezone());
	}
	
	public static function getUserTimezone() {
		// Try user timezone
		if (!empty($_SESSION['timezone'])) {
			$user_timezone = $_SESSION['timezone'];
			try {
				return new DateTimeZone($user_timezone);
			} catch (Exception $e) {}
		}
		
		// Try config timezone
		$config_timezone = WConfig::get('config.timezone');
		if (!empty($config_timezone)) {
			try {
				return new DateTimeZone($config_timezone);
			} catch (Exception $e) {}
		}
		
		// User server timezone
		$server_timezone = ini_get('date.timezone');
		if (!empty($server_timezone)) {
			try {
				return new DateTimeZone($server_timezone);
			} catch (Exception $e) {}
		}
		
		// Default is GMT
		return new DateTimeZone('GMT');
	}
	
	/**
	 * Translates the object into string: 15/01/2013 13:37
	 * 
	 * @return string
	 */
	public function __toString() {
		return $this->format('Y-m-d H:i:s');
	}
}

?>