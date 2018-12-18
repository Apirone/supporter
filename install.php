<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	
	<title>Install Page</title>
  </head>
	
<body>
<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
	
	if(isset($_POST["install"])) {
		
		if ($_POST["btc"]<>"") {
			// create wallet with payment forwarding
			$json_data = json_encode(
				array (
					"type" => "forwarding",
					"destinations" => array(array("address" => $_POST["btc"] ))
				)
			);
			
		} else {
			// create an anonymous saving wallet
			$json_data = json_encode(array ("type"  =>  "saving"));			
		}

		$api_endpoint = "https://apirone.com/api/v2/btc/wallet";

		$curl = curl_init($api_endpoint);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$http_status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$response = curl_exec($curl);
		curl_close($curl);
		
		$decoded = json_decode($response, true);
		
		// return errors if appear
		if (isset($decoded["message"])) {die ("ERROR: " . $decoded["message"]);}

		$settings = fopen("include/settings.php", "w") or die("ERROR: Unable to open settings file!");
		
		// generate random secret code for callback
		for ($secret = '', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')-1; $i != 10; $x = rand(0,$z), $secret .= $a{$x}, $i++); 
		
		$set = "<?php\n".'	$onepx = 10000;    // price of one pixel in Satoshi'.";\n".'	$secret_for_callback = "'. $secret . '"'.";\n".'	$host = "'.$_POST["host"].'"'.";\n".'	$db = "'.$_POST["db"].'"'.";\n".'	$user = "'.$_POST["user"].'"'.";\n".'	$pass = "'.$_POST["pass"].'"'.";\n".'	$callback = "'.$_POST["callback"].'"'.";\n".'	$WalletID = "'.$decoded["wallet"].'"'.";\n".'	$Key = "'.$decoded["transfer_key"].'"'.";\n";

		if ($_POST["btc"]<>""){$set = $set .  '	$btc = "'.$_POST["btc"].'"'.";\n";}
	
		$set = $set . "?>";
		
		fwrite($settings, $set);
		fclose($settings);

		include("include/settings.php");
		
		$link = mysqli_connect($host,$user, $pass, $db) or die(mysql_error());
		if ($link->connect_errno) {
			die("Can't connect: " . $link->connect_error);
			exit();
		}
		
		$query = "
		DROP TABLE IF EXISTS `supporters`;
		
		CREATE TABLE `supporters` (
		  `id` int(11) NOT NULL,
		  `address` varchar(34) NOT NULL,
		  `logo` varchar(250) NOT NULL,
		  `link` varchar(250) NOT NULL,
		  `amount` int(11) NOT NULL,
		  `confirmations` tinyint(4) NOT NULL,
		  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
		ALTER TABLE `supporters` ADD PRIMARY KEY (`id`);
		
		ALTER TABLE `supporters` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
		
		INSERT INTO `supporters` (`id`, `address`, `logo`, `link`, `amount`, `confirmations`, `ts`) VALUES
		(NULL, '3KNZz4ipKkriCecXbv6NnS8f6dhVrb1vZ5', 'https%3A%2F%2Fwww.google.com%2Fimages%2Fbranding%2Fgooglelogo%2F2x%2Fgooglelogo_color_272x92dp.png', 'https%3A%2F%2Fwww.google.com', 1000000, 0, CURRENT_TIMESTAMP);";

		if ($link->multi_query($query) === FALSE) { die ("ERROR: " . $link->error);}

		die ('<h3 class="text-center">Installation Done. <a href="become-a-supporter.php">Open site to see result</a>.</h3><p class="text-muted text-center">Please delete file install.php.</p></body></html>');
	}
?>
	<div class="container">

		<h3>Install</h3>

		  <form method="post">
			<div class="form-group">
				<label for="lpass">Store root URL (for callback, http or https prefix and page "/callback.php" is required. )</label>
				<input type="text" id="lcallback" name="callback" class="form-control" value="https://www.example.com/callback.php" required>

				<hr>
				
				<h3>MySQL config:</h3>
				<label for="lhost">Host</label>
				<input type="text" id="lhost" name="host" class="form-control mb-3" placeholder="Example: localhost" required>

				<label for="lhost">Database</label>
				<input type="text" id="ldb" name="db" class="form-control mb-3" placeholder="Example: simple" required>

				<label for="luser">Username</label>
				<input type="text" id="luser" name="user" class="form-control mb-3" placeholder="Example: user" required>

				<label for="lpass">Password</label>
				<input type="text" id="lpass" name="pass" class="form-control mb-3" placeholder="8-64 length" required>

				<hr>
				
				<h3>Bitcoin Address (optional)</h3>
				<input type="text" id="lbtc" name="btc" class="form-control mb-3" placeholder="Your bitcoin address for forwarding">
				<p class="text-muted">Enter your Bitcoin address if you would like to immediatly forward all income payments to your wallet.<br>
				   Keep this field empty If you want to accept all payments without any fee and store in an anonymous wallet.
				</p>

				<input type="hidden" name="install" value="1">

				<input type="submit" value="Submit" class="btn btn-primary">
		    </div>
		  </form>
		</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
