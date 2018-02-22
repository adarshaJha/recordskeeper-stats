<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, target-densitydpi=device-dpi">
    <title>Stats - Recordskeeper</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.png">

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href = "css/style.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  </head>

  <body>
  <!-- prelaoder spins here -->
  	<div class="se-pre-con"></div>
  <!-- prelaoder spins here -->

 <!-- header here  -->
   			<header id="top">
				<p id="logo">
					<img src="images/logo.png">
				</p>
				<nav id="skip">
					
				</nav>
				<nav id="nav">
					<ul>
						<label id="togglecontlabel">TestNetwork</label>
					</ul>	
				</nav>
			</header>
<!-- header ends here  -->

    <!-- Page Content -->
    <div class="container faucetcontainer">
       <div class ="row">
        	<div class="col-sm-4">
        	  	
	        		<p>
	        			<i class="fas fa-th-large font55"></i>
	        			<span class="cardheading">	BEST BLOCK </span>
	        			<span class="cardheading ">	#5,134,698 </span>
	        		</p>
        			
        	    
        	</div>
        	<div class="col-sm-4">
        			<p>
	        			<i class="fas fa-stopwatch font55"></i>
	        			<span class="cardheading">	LAST BLOCK </span>
	        			<span class="cardheading ">10.98 S ago </span>
	        		</p>
        	</div>
        	<div class="col-sm-4">
        			<p>
	        			<i class="fas fa-hourglass-half font55"></i>
	        			<span class="cardheading">	TOTAL XRK MINED </span>
	        			<span class="cardheading ">	1,000,000 </span>
	        		</p>
        	</div>
       </div>
	   <div class ="row">
        	<div class="col-sm-4">
        	  	
	        		<p>
	        			<i class="fas fa-th-large font55"></i>
	        			<span class="cardheading"> NO. OF TRANSACTIONS </span>
	        			<span class="cardheading ">	#12 </span>
	        		</p>
        			
        	    
        	</div>
        	<div class="col-sm-4">
        			<p>
	        			<i class="fas fa-stopwatch font55"></i>
	        			<span class="cardheading">PENDING TRANSACTIONS </span>
	        			<span class="cardheading ">#34 </span>
	        		</p>
        	</div>
        	<div class="col-sm-4">
        			<p>
	        			<i class="fas fa-hourglass-half font55"></i>
	        			<span class="cardheading">	AVG BLOCK TIME </span>
	        			<span class="cardheading ">	1.98 S </span>
	        		</p>
        	</div>
       </div>
       <div class ="row">
        	<div class="col-sm-6">
			<h2>Difficulty</h2>
        	    <div class="cardss">
        			<canvas id="myChart" width="1000" height="200"></canvas>
        		</div>
        	</div>
			<div class="col-sm-6">
			<h2>Hast Rate</h2>
        	    <div class="cardss">
				<canvas id="mycHART" width="1000" height="200"></canvas>
        		</div>
        	</div>
       </div>
	   <div class ="row">
        	<div class="col-sm-6">
			<h2>Transaction Fees</h2>
        	    <div class="cardss">
				<canvas id="txfee" width="1000" height="200"></canvas>
        		</div>
        	</div>
       </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.all.min.js"></script>
   
    </script>
    <script src ="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js"></script>
    <script src="js/stats.js"></script>
   
    <script>

</script>
  </body>

</html>