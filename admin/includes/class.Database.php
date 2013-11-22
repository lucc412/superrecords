<?php
ini_set("display_errors", '0');
session_start();
date_default_timezone_set('Australia/Melbourne');
class Database
{
	var $connection;

        public function Database()
	{
		$serverName = "localhost";
		$databaseUser = "root";
		$databasePassword = "";
		$databaseName = "superrec_dev1";

		//$databasePort = 3306;
		$this->connection = mysql_connect ($serverName, $databaseUser, $databasePassword) or die('I cannot connect to the database. Please edit test/development.conf.php with your database configuration.');
		mysql_select_db ($databaseName) or die ('I cannot find the specified database "'.$databaseName.'". Please edit test/development.conf.php.');
	}

} // end of Database class

?>