<?php 
if ($_COOKIE["rk-network"] == "test")
$config = include('src/config-testnet.php');
else $config = include('src/config-mainnet.php');

$rkGenesisTimestamp = $config["genesis-timestamp"];

$rkAgeDays = (int)( ( time() -  $rkGenesisTimestamp) / (3600 * 24));

$rkMonths = 0;
$rkDays = 0;

if( $rkAgeDays >= 30) {
	$rkMonths = (int)($rkAgeDays/30);
	$days = (int)($rkAgeDays - $rkMonths * 30);
	$rkAgeDispaly = "$rkMonths months";
	if ($days > 0) $rkAgeDispaly = $rkAgeDispaly . " $days days"; 
}
else {
	$days = $rkAgeDays;
	$rkAgeDispaly = "$days days"; 
}

?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, target-densitydpi=device-dpi">
    <title>Stats - Recordskeeper</title>
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.png">

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href = "assets/css/style.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  </head>

  <body>
  <!-- prelaoder spins here -->
  	<div class="se-pre-con"></div>
  <!-- prelaoder spins here -->

 <!-- header here  -->
   			<header id="top">
				<p id="logo">
					<img src="assets/images/logo.png">
				</p>
				<nav id="nav">
                    <ul>                     
                        <div id="togglecont">
                            <input class="tgl tgl-light" id="cb1" type="checkbox"/>
                           <label class="tgl-btn" for="cb1"></label>
                        </div>
                        <span >
                            <label id="togglecontlabel">MainNet</label>
                        </span>
                    </ul>                
                </nav>	
			</header>
<!-- header ends here  -->

    <!-- Page Content -->
    <div class="container faucetcontainer">
       <div class ="row">
        	<div class="col-sm-4">
        	  	
	        		<p>
	        			<i class="fas fa-th-large font30"></i>
	        			<span class="cardheading">	BEST BLOCK </span>
	        			<span class="cardheading" id="best_block"> </span>
	        		</p>
        			
        	    
        	</div>
        	<div class="col-sm-4">
        			<p>
	        			<i class="fas fa-stopwatch font30"></i>
	        			<span class="cardheading">	LAST BLOCK </span>
						<span class="cardheading" id="last_block_time_diff">0 s ago</span>
						<span id='last_block_time' style="display:none"></span>
	        		</p>
        	</div>
        	<div class="col-sm-4">
        			<p> 
	        			<i class="fas fa-hockey-puck font30"></i>
	        			<span class="cardheading">	TOTAL XRK MINED </span>
	        			<span class="cardheading" id="xrk_supply"></span>
	        		</p>
        	</div>
       </div>
	   <div class ="row mbt">
        	<div class="col-sm-4">
        	  	
	        		<p>
	        			<i class="fas fa-hashtag font30"></i>
	        			<span class="cardheading"> NO. OF TRANSACTIONS </span>
						<span class="cardheading" id="tx_count"></span>
	        		</p>
        			
        	    
        	</div>
        	<div class="col-sm-4">
        			<p>
	        			<i class="fas fa-list-ul font30"></i>
	        			<span class="cardheading">PENDING TRANSACTIONS </span>
	        			<span class="cardheading" id="pending_tx_count"> </span>
	        		</p>
        	</div>
        	<div class="col-sm-4">
        			<p>
	        			<i class="fas fa-clock font30"></i>
	        			<span class="cardheading">	AVG BLOCK TIME </span>
	        			<span class="cardheading" id="avg_time"></span>
	        		</p>
        	</div>
	   </div>
	   <div class ="row mbt">
		<div class="col-sm-4">
			  
				<p>
					<i class="fas fa-hourglass-half font30 font30"></i>
					<span class="cardheading"> BLOCKCHAIN AGE </span>
					<span class="cardheading" id="rk_age"><?php echo $rkAgeDispaly ?></span>
				</p>
				
			
		</div>

        <div class="col-sm-4">
              
                <p>
                    <i class="fas fa-hourglass-half font30 font30"></i>
                    <span class="cardheading"> MAX BLOCK SIZE </span>
                    <span class="cardheading" id="rk_age">8 MB</span>
                </p>
                
            
        </div>

     
		</div>
       <div class ="row mbt margintop30">
        	<div class="col-sm-6">
			<h2 class="heading">Difficulty</h2>
        	    <div class="cardss">
        			<canvas id="diffChart" width="1000" height="200"></canvas>
        		</div>
        	</div>
			<div class="col-sm-6">
			<h2 class="heading">Hash Rate</h2>
        	    <div class="cardss">
				<canvas id="hashChart" width="1000" height="200"></canvas>
        		</div>
        	</div>
       </div>
    </div>
        <footer id="footer">
        <ul>
         <li>&copy; RecordsKeeper @<span class="date">2016-2018. All rights reserved</span></li>
    <li><a href="./" target="_blank">Terms</a></li>
    <li><a href="./" target="_blank">Privacy Policy</a></li>
        <li><a href="http://explorer.recordskeeper.co/" target="_blank">Mainnet Explorer</a></li>
        <li><a href="http://test-explorer.recordskeeper.co/" target="_blank">Testnet Explorer</a></li>

        <li><a href="http://faucet.recordskeeper.co/" target="_blank">Faucet</a></li>
        
        <li><a href="http://miner.recordskeeper.co/" target="_blank">Miner Statistics</a></li>
        <li><a href="http://airdrop.recordskeeper.co/" target="_blank">Airdrop</a></li>
        <li><a href="http://demo.recordskeeper.co/" target="_blank">Demo</a></li>
        <li><a href="https://docs.recordskeeper.co/" target="_blank">Docs</a></li>

        </ul>
        </footer>
    <!-- Bootstrap core JavaScript -->
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.all.min.js"></script>
   
    </script>
    <script src ="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js"></script>
    <script src="assets/js/stats.js?v2"></script>
   
    <script>

</script>
  </body>

</html>
