<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include("include/settings.php");

//receive JSON data
$data = file_get_contents('php://input');

if ($data) {
    $params = json_decode($data, true);


	// checking secret code to confirm source of callback
	if ($params["data"]["secret"] == $secret_for_callback) {

		$link = mysqli_connect($host,$user, $pass, $db) or die(mysql_error());


		if ($params["confirmations"] == 0) {

			$q = $link->prepare('INSERT INTO `supporters` (`id`, `address`, `logo`, `link`, `amount`, `confirmations`, `ts`) VALUES (NULL, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)');

			$q->bind_param("sssss", $params["input_address"], $params["data"]["logo"], $params["data"]["link"], $params["value"], $params["confirmations"]);

			$q->execute();
		
			// we confirm payment by first callback, but you can change it to 1-6 confirmations
			echo "*ok*";

		}
		
		if ($params["confirmations"] > 0) {
			
			$q = $link->prepare('UPDATE `supporters` SET `confirmations` = ? WHERE `address` = ?');

			$q->bind_param("ss", $params["confirmations"], $params["input_address"]);
		}

	}
}


?>