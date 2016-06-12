<?php
/**
 *  Managerul bazei de date
 */
class DB extends PDO {
	/**
	 * @var PDO Link to connection
	 */
	private static $instance;
	private static $_dsn = 'mysql:host=127.0.0.1;dbname=beefreelancerdb';
	private static $_user = "root";
	private static $_password = "";

	/**
	 * Creates a PDO instance representing a connection to a database
	 * @param $dsn
	 * @param $username [optional]
	 * @param $password [optional]
	 * @param $options [optional]
	 */
	public function __construct($dsn, $username = NULL, $password = NULL, $options = NULL) {
		parent::__construct($dsn, $username, $password, $options);
	}

	/**
	 * @static Return PDO connection instance
	 * @return PDO Link to connection
	 * @throws Exception
	 */
	public static function getInstance() {
		if (is_null(self::$instance)){
			try {
				self::$instance = new self(self::$_dsn, self::$_user, self::$_password);
				self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch (PDOException $e) {
				print "Error: " . $e->getMessage();
				die();
			}
		}
		return self::$instance;
	}
}