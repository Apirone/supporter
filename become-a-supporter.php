<?php include("include/settings.php");?>
<!doctype html>
<html lang="en">
  <head>
	  
    <title>Become a supporter</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	  <style>
	  .flip-container {
		  -webkit-perspective: 1000;
		  -moz-perspective: 1000;
		  -o-perspective: 1000;
		  perspective: 1000;
		}

		.flip-container .flipper.rotate {
		  -webkit-transform: rotateY(180deg);
		  -moz-transform: rotateY(180deg);
		  -o-transform: rotateY(180deg);
		  transform: rotateY(180deg);
		}

		.flip-container,
		.front,
		.back {
		  width: 100%;
		  height: 300px;
		}

		.flipper {
		  -webkit-transition: 0.6s;
		  -webkit-transform-style: preserve-3d;
		  -moz-transition: 0.6s;
		  -moz-transform-style: preserve-3d;
		  -o-transition: 0.6s;
		  -o-transform-style: preserve-3d;
		  transition: 0.6s;
		  transform-style: preserve-3d;
		  position: relative;
		}

		.front,
		.back {
		  -webkit-backface-visibility: hidden;
		  -moz-backface-visibility: hidden;
		  -o-backface-visibility: hidden;
		  backface-visibility: hidden;
		  position: absolute;
		  top: 0;
		  left: 0;
		  text-align: center;
		}

		.front {
		  z-index: 2;
		  background-color: #343a40;
		}

		.back {
		  -webkit-transform: rotateY(180deg);
		  -moz-transform: rotateY(180deg);
		  -o-transform: rotateY(180deg);
		  transform: rotateY(180deg);
		  background-color: white;
		  }
	  .btn-outline-info {
			background-color: white;
		}
	  .img-thumbnail {
		    padding: 0;
    		border: none;
			background-color: initial;
	   }
	  </style>
	</head>
  <body>

	<div class="container">
		
	<?php 
	//	$data = file_get_contents("https://apirone.com/api/v1/ticker");
	//	$respond = json_decode($data,true);
	//	$usd = $respond["USD"]["last"];
		$usd= 3500;

		$onepx = 10000;    // one pixel cost
		$first = 100000;    // first icon size in Satoshi
		$second = 1000000;  // second icon size in Satoshi
	?>		
	<main>
      <div class="jumbotron p-3 p-md-5 text-white rounded bg-dark row">
        <div class="col-md-6 px-0">
          <h1 class="display-4 font-italic">Become a Supporter</h1>
          <p class="lead my-3">Publishing link here, you support our development and gain visitors to your project. Just add link to your logo and site URL. Pay any amount for your wish. 1 pixel cost = <?php echo $onepx ?> Satoshi.<br>
		  We recomend to send minimum 0.01 BTC and get 100x100 pixels for round Logo button. For example:</p>
		<p class="small">

		  <?php echo round($first/100000000,8); ?> BTC = $ <?php echo round($usd/100000000*$first,2); ?> USD = <?php echo $first/$onepx. "x". $first/$onepx; ?> px = <a href="https://google.com/" target="_blank"><img src="img/googleg_standard_color_128dp.png" alt="https://google.com/" width=<?php echo $first/$onepx; ?> height=<?php echo $first/$onepx; ?> class="m-1 img-thumbnail" style="vertical-align: sub;"></a><br>

		  <?php echo round($second/100000000,8); ?> BTC = $ <?php echo round($usd/100000000*$second,2); ?> USD = <?php echo $first/$onepx. "x". $first/$onepx; ?> px = <a href="https://google.com/" target="_blank"><img src="img/googleg_standard_color_128dp.png" alt="https://google.com/" width=<?php echo $second/$onepx; ?> height=<?php echo $second/$onepx; ?> class="m-1 img-thumbnail"></a>
		</p>
        </div>
		  
		<div class="col-md-6">
			<div class="ourtrainers">
			  <div class="flip-container">
				<div class="flipper">
				  <div class="front rounded d-flex align-items-center">
					<div class="box1 col-md-12 text-white">
					 	<form method="post" id="reg-form">
						  <div class="form-group text-left text-muted">
							<label for="exampleFormControlInput1">Image link to logo</label>
							<input type="logo" name="logo" class="form-control" id="exampleFormControlInput1" placeholder="https://example.com/logo.jpg" >
						  </div>
						  <div class="form-group text-left text-muted">
							<label for="exampleFormControlSelect1">Site URL</label>
							<input type="link" name="link" class="form-control" id="exampleFormControlSelect1" placeholder="https://example.com" >
						  </div>							
						<button type="submit" id="submit" class="btn btn-outline-info submit ">Become a Supporter</button>
					</form>
					</div>

				  </div>
				  <div class="back rounded d-flex align-items-center">
					<div class="box2">
					  <div class="ourtrainers-text-back">
						  <div id="form" class="result p-3" style="text-align:left;"></div>
						  <div class="col-lg-12 text-muted text-center" style="cursor: pointer;" id="return">Return to edit.</div>
						</div>
						
					</div>
				  </div>
				</div>
			  </div>
		</div>
      </div>		  
      </div>
	</main>
		  
	<h4>Supporters:</h4>
	<div class="row d-flex justify-content-center">
		
		<div class="col-md-12 pb-5">
			<?php
				$link = mysqli_connect($host,$user, $pass, $db) or die(mysql_error());

				$q = $link->query ("SELECT * FROM `supporters` ORDER BY `ts` DESC" );
				while ($row = $q->fetch_array()) {
					
					if ($row["logo"]<>''){
						echo '<a href="'. urldecode($row["link"]) .'" target="_blank"><img src="'. urldecode($row["logo"]) .'" alt="'. urldecode($row["link"]) .'" width="'. $row["amount"]/$onepx .'" height="'. $row["amount"]/$onepx .'" class="img-thumbnail m-3"></a>';
					} else {
						echo '<a href="'. urldecode($row["link"]) .'" target="_blank"><img src="/static/img/transparent.png" alt="'. urldecode($row["link"]) .'"  class="img-thumbnail m-3" style="background-color: #'. hash("crc32", urldecode($row["link"])) .'; width: '. $row["amount"]/$onepx .'px; height: '. $row["amount"]/$onepx .'px;"></a>';
					}
				}
			?>
		</div>
  </div>
</div>	

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

	<script type="text/javascript">
	$(document).ready(function()
	{	
		$(document).on('submit', '#reg-form', function()
		{

			var data = $(this).serialize();

			$.ajax({

			type : 'POST',
			url  : 'payment.php',
			data : data,
			success :  function(data)
					   {						
	//						$("#reg-form").fadeOut(500).hide(function()
							$("#reg-form").show(function()
							{
								$(".result").fadeIn(500).show(function()
								{
									$(".result").html(data);
								});
							});

					   }
			});
			return false;
		});
	});
	</script>

	<script>
		$('.submit').click(function(){
		  $('.flipper').toggleClass('rotate');
		});
		$('#return').click(function(){
		  $('.flipper').toggleClass('rotate');
		});
	</script>
	  

</body>
</html>