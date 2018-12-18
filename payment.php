<?php
include("include/settings.php");
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if ($_POST) {
	  $json_data = array (
		"callback" => array(
			'url'=> $callback,
			'data'=> array (
				'link'=> urlencode($_POST["link"]),
				'logo'=> urlencode($_POST["logo"]),
				'secret'=> $secret_for_callback
			)
		)
	  );

	  $api_base = "https://apirone.com/api/v2/btc/wallet/". $WalletID ."/address";

	  $curl = curl_init($api_base);
	  curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
	  curl_setopt($curl, CURLOPT_POST, 1);
	  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($json_data));
	  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	  $http_status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	  $response = curl_exec($curl);
	  curl_close($curl);

	  $decoded = json_decode($response, true);


?>
				<div class="row">
				  <div class="col-xl-4 col-lg-12 col-md-12 text-center qr">
					<img src="<?php echo "https://apirone.com/api/v1/qr?message=". urlencode( "bitcoin:".$decoded["address"]."?amount=0.01");?>&format=svg" alt="QR code" class="img-fluid" style="max-height: 150px;">
				  </div>
				  <div class="col-xl-8 col-lg-12 col-md-12 pt-3">
					<div class="text-center text-xl-left pb-3">
						<img src="img/bitcoin_logo_vector.svg" class="img-fluid" style="max-height: 30px;" alt="Bitcoin logo"><br>
					</div>
					<div class="text-center text-xl-left" style="word-break: break-word;font-size: 0.9rem; color: black;">
					<?php echo $decoded["address"]; ?><br><span class="text-muted">Payment will be credited immediatly.</span>							   </div>
				  </div>
				</div>
<script>
// Call function every 3 sec
setInterval( ajax_query, 3000)

function ajax_query(success) {
    jQuery.ajax({
        url: "payment.php?wallet=<?php echo $decoded["address"]; ?>",
        type: "GET",
        success:   function(data)
				   {
					 if (data=="0") {
						// this payment support unconfirmed transactions because amounts is small and we trust customers
						// you can modify script and verify payment by 1-6 confirmations
						// if payment done, we refresh page
						$(".qr").html('<img src="img/check.gif" alt="done" class="img-fluid" style="max-height: 150px;">');
						setTimeout(function () { location.reload(true); }, 5000);
					 }
				   }
    });
}
</script>
<?php } 

// checking payment
if ($_GET) {
	if ($_GET["wallet"]){
		// check the address in the database
		$address = preg_replace ("/[^a-zA-Z0-9:]/", "", $_GET["wallet"]);

		$link = mysqli_connect($host,$user, $pass, $db) or die(mysql_error());

		$q = $link->prepare('SELECT * FROM `supporters` WHERE `address`= ?');

		$q->bind_param("s", $address);

		$q->execute();

        $q->store_result();

        // In this case we finish payment with Zero confirmations  
		if ($q->num_rows>=1){echo "0";}
	}
}
?>