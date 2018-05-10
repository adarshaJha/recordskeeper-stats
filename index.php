<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
   

    <title>Records Keeper stats</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
  </head>
<style>
    .main .site-header,.main .mapmaindiv{background-color:#54b3ce}
    .main .widgetheading{background-color:#54b3ce}
     .main #map_bombs path{fill:#96c5de !important;stroke:#96c5de !important}
    .maplabel{display: block;
    width: calc(100% + 30px);
    background: #1d2441;
    padding: 4px;
    margin-left: -15px;box-shadow: 0px 5px 10px #0000006b}
    </style>
  <body data-url="main">

    <nav class="site-header sticky-top py-1">
      <div class="float-left">
        <a class="py-2 d-md-inline-block" href="#"><img src="images/logo.svg" class="logosvg"></a>
      </div>
        <div style="margin-top: 15px">
        <div class="labelnetwrk">Main Network</div>
        <label class="switch float-right">
  <input type="checkbox" id="checkboxnetwork" checked>
  <span class="slider round"></span>
</label>
            </div>
    </nav>
<div class="clearfix"></div>
      
      <div class="wrapper">
      <div class="row">
          
          <div class="col-md-12 col-sm-12 col-lg-12 main-row">
              <div class="widgetheading">Blackchain Stats</div>
          <div class="col-md-2 col-sm-12 col-lg-2 float-left flotablediv">
              <div class="widgetblock">
                  <div class="widget-icon">
                      <span><img src="images/icon1.svg"></span>
                  </div>
                  <div class="widgettext">
                  <span class="labelwid">AVG. RECORDS PUBLISHED</span>
                      <div class="clearfix"></div>
                      <span class="mainnumber" id="averagerecordpublish">0</span> <span class="numberunit">RECORDS/SEC</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-2 col-sm-12 col-lg-2 float-left flotablediv">
              <div class="widgetblock">
                  <div class="widget-icon">
                      <span><img src="images/icon2.svg"></span>
                  </div>
                  <div class="widgettext">
                  <span class="labelwid">TOTAL RECORDS PUBLISHED</span>
                      <div class="clearfix"></div>
                      <span class="mainnumber" id="totalrecordspublish">0</span> <span class="numberunit">RECORDS</span>
                  </div>
                  </div>
          </div>
             <div class="col-md-2 col-sm-12 col-lg-2 float-left flotablediv">
              <div class="widgetblock">
                  <div class="widget-icon">
                      <span><img src="images/icon3.svg"></span>
                  </div>
                   <div class="widgettext">
                  <span class="labelwid">TOTAL ADDRESSES</span>
                      <div class="clearfix"></div>
                      <span class="mainnumber counter" id="totaladdress">0</span>
                  </div>
                  </div>
          </div>
              <div class="col-md-2 col-sm-12 col-lg-2 float-left flotablediv">
              <div class="widgetblock">
                  <div class="widget-icon">
                      <span><img src="images/icon4.svg"></span>
                  </div>
                   <div class="widgettext">
                  <span class="labelwid">AVG. DATA PUBLISHED</span>
                      <div class="clearfix"></div>
                      <span class="mainnumber" id="averagedatapublished">0</span> <span class="numberunit">MB/SEC</span>
                  </div>
                  </div>
          </div>
              <div class="col-md-2 col-sm-12 col-lg-2 float-left flotablediv">
              <div class="widgetblock">
                  <div class="widget-icon">
                      <span><img src="images/icon5.svg"></span>
                  </div>
                  <div class="widgettext">
                  <span class="labelwid yellow">ACTIVE MINERS</span>
                      <div class="clearfix"></div>
                      <span class="mainnumber counter" id="activeminers">0</span>
                  </div>
                  </div>
          </div>
               <div class="col-md-2 col-sm-12 col-lg-2 float-left flotablediv">
              <div class="widgetblock">
                  <div class="widget-icon">
                      <span><img src="images/icon6.svg"></span>
                  </div>
                  <div class="widgettext">
                  <span class="labelwid green">TOTAL XRX MINED</span>
                      <div class="clearfix"></div>
                      <span class="mainnumber counter" id="totalxrxsupply">0</span>
                  </div>
                  </div>
          </div>
          
          </div></div>
      <div class="col-md-8 col-lg-8 col-sm-12 padding_0 float-left">
      <div class="row">
          
          <div class="col-md-12 col-sm-12 col-lg-12">
              <div class="widgetheading col-md-12 border-right">Black Stats</div>
          <div class="col-md-3 col-sm-12 col-lg-3 float-left flotablediv">
              <div class="widgetblock seperator">
                  <div class="widget-icon">
                      <span><img src="images/icon7.svg"></span>
                  </div>
                  <div class="widgettext">
                  <span class="labelwid green">BEST BLOCK</span>
                      <div class="clearfix"></div>
                      <span class="mainnumber green" id="bestblocknumber">0</span>
                  </div>
                  </div>
              <div class="widgetblock">
                  <div class="widget-icon">
                      <span><img src="images/icon11.svg"></span>
                  </div>
                  <div class="widgettext">
                  <span class="labelwid">AVG. RECORDS PUBLISHED</span>
                      <div class="clearfix"></div>
                      <span class="mainnumber" id="avgperblockrecords">0</span>
                      <span class="numberunit">RECORDS/BLOCK</span>
                  </div>
                  </div>
              
          </div>
            <div class="col-md-3 col-sm-12 col-lg-3 float-left flotablediv">
              <div class="widgetblock seperator">
                  <div class="widget-icon">
                      <span><img src="images/icon8.svg"></span>
                  </div>
                  <div class="widgettext">
                  <span class="labelwid green">LAST BLOCK</span>
                      <div class="clearfix"></div>
                      <span class="mainnumber" id="lastcreatedblock">0</span>
                      <span class="numberunit">SEC AGO</span>
                  </div>
                  </div>
                 <div class="widgetblock"> 
                  <div class="widget-icon">
                      <span><img src="images/icon12.svg"></span>
                  </div>
                      <div class="widgettext">
                  <span class="labelwid">AVG. DATA PUBLISHED</span>
                      <div class="clearfix"></div>
                      <span class="mainnumber" id="avgdatepublishperblock">0</span>
                      <span class="numberunit">MB/BLOCK</span>
                  </div>
                  </div>
          </div>
             <div class="col-md-3 col-sm-12 col-lg-3 float-left flotablediv">
              <div class="widgetblock seperator">
                  <div class="widget-icon">
                      <span><img src="images/icon9.svg"></span>
                  </div>
                  <div class="widgettext">
                  <span class="labelwid">AVG. BLOCK TIME</span>
                      <div class="clearfix"></div>
                      <span class="mainnumber" id="avgblocktimeall">12</span>
                      <span class="numberunit">SEC</span>
                  </div>
                  </div>
                  <div class="widgetblock">
                  <div class="widget-icon">
                      <span><img src="images/icon13.svg"></span>
                  </div>
                      <div class="widgettext">
                  <span class="labelwid">MEDIAN BLOCK SIZE</span>
                      <div class="clearfix"></div>
                      <span class="mainnumber" id="medianblocksize">0</span>
                      <span class="numberunit">MB/BLOCK</span>
                  </div>
                      
                  </div>
          </div>
              <div class="col-md-3 col-sm-12 col-lg-3 float-left flotablediv">
              <div class="widgetblock seperator">
                  <div class="widget-icon">
                      <span><img src="images/icon10.svg"></span>
                  </div>
                  <div class="widgettext">
                  <span class="labelwid">MAX BLOCK SIZE</span>
                      <div class="clearfix"></div>
                      <span class="mainnumber counter" id="maxblocksize">0</span>
                      <span class="numberunit">MB</span>
                  </div>
                  </div>
                   <div class="widgetblock">
                  <div class="widget-icon">
                     
                  </div>
                  </div>
          </div>
              
              
          
          </div></div>
          
          <div class="row">
          
          <div class="col-md-12 col-sm-12 col-lg-12">
              <div class="widgetheading col-md-12 border-right">transaction Stats</div>
          <div class="col-md-3 col-sm-12 col-lg-3 float-left flotablediv">
              <div class="widgetblock">
                  <div class="widget-icon">
                      <span><img src="images/icon14.svg"></span>
                  </div>
                  <div class="widgettext">
                  <span class="labelwid purple">TRANSACTION FEES</span>
                      <div class="clearfix"></div>
                      <span class="mainnumber counter" id="transactionfess">0</span>
                      <span class="numberunit">XRK/KB</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-3 col-sm-12 col-lg-3 float-left flotablediv">
              <div class="widgetblock">
                  <div class="widget-icon">
                      <span><img src="images/icon15.svg"></span>
                  </div>
                   <div class="widgettext">
                  <span class="labelwid green">TOTAL TRANSACTION</span>
                      <div class="clearfix"></div>
                      <span class="mainnumber" id="totaltransaction">0</span>
                      
                  </div>
                  </div>
          </div>
             <div class="col-md-3 col-sm-12 col-lg-3 float-left flotablediv">
              <div class="widgetblock">
                  <div class="widget-icon">
                      <span><img src="images/icon16.svg"></span>
                  </div>
                  <div class="widgettext">
                  <span class="labelwid green">PENDING TRANSACTION</span>
                      <div class="clearfix"></div>
                      <span class="mainnumber counter" id="pendingtransaction">0</span>
                      
                  </div>
                  </div>
          </div>
              <div class="col-md-3 col-sm-12 col-lg-3 float-left flotablediv">
              <div class="widgetblock">
                  <div class="widget-icon">
                      <span><img src="images/icon17.svg"></span>
                  </div>
                  <div class="widgettext">
                  <span class="labelwid green">MAX TRANSACTION SIZE</span>
                      <div class="clearfix"></div>
                      <span class="mainnumber counter" id="maxtransactionsize">0</span>
                      <span class="numberunit">MB</span>
                      
                  </div>
                  </div>
          </div>
              
          
          </div></div>
          </div>
      <div class="col-md-4 col-lg-4 col-sm-12 float-left mapmaindiv">
          <span class="labelwid green maplabel">GEOGRAPHICALLY ACTIVE NODES</span>
           <div id="map_bombs" style="width:100%;height: 259px;"></div>
          
          </div>
          <div class="clearfix"></div>
           <div class="row">
          
          <div class="col-md-12 col-sm-12 col-lg-12">
              <div class="widgetheading col-md-12 border-right chartheader">&nbsp;</div>
          <div class="col-md-5ths col-xs-6 col-sm-12  float-left flotablediv">
              <div class="widgetblock chartheight chartbg">
                  <span class="labelwid">DIFFICULTY VS NO. OF BLOCKS</span>
                 <div id="myChart">
                     <canvas></canvas>
                     </div>
                  
                  </div>
          </div>
             <div class="col-md-5ths col-xs-6 col-sm-12 float-left flotablediv">
              <div class="widgetblock chartheight chartbg">
                  <span class="labelwid">HASH RATE VS NO. OF BLOCKS</span>
                 <div id="myChart1">
                     <canvas></canvas>
                     </div>
                  
                  </div>
          </div>
             <div class="col-md-5ths col-xs-6 col-sm-12  float-left flotablediv">
              <div class="widgetblock chartheight chartbg">
                   <span class="labelwid">AVG. BLOCK TIME</span>
                 <div id="myChart2">
                     <canvas></canvas>
                     </div>
                  
                  </div>
          </div>
               <div class="col-md-5ths col-xs-6 col-sm-12  float-left flotablediv">
              <div class="widgetblock chartheight chartbg">
                   <span class="labelwid">NO. OF TRANSACTION VS BLOCK</span>
                 <div id="myChart3">
                     <canvas></canvas>
                     </div>
                  
                  </div>
          </div>
               <div class="col-md-5ths col-xs-6 col-sm-12 float-left flotablediv">
              <div class="widgetblock chartheight chartbg">
                   <span class="labelwid">MEDIAN FEE VS BLOCK</span>
                 <div id="myChart4">
                     <canvas></canvas>
                     </div>
                  
                  </div>
          </div>
              
          
          </div></div>
          
          <div class="row">
          
          <div class="col-md-12 col-sm-12 col-lg-12">
              <div class="widgetheading col-md-12 border-right chartheader">&nbsp;</div>
          <div class="col-md-5ths col-xs-6 col-sm-12  float-left flotablediv">
              <div class="widgetblock chartheight chartbg">
                 <span class="labelwid">DIFFICULTY VS TIME</span>
                  <div id="myChart5">
                     <canvas></canvas>
                     </div>
                  </div>
          </div>
             <div class="col-md-5ths col-xs-6 col-sm-12 float-left flotablediv">
              <div class="widgetblock chartheight chartbg">
                  <span class="labelwid">HASH RATE VS TIME</span>
                   <div id="myChart6">
                     <canvas></canvas>
                     </div>
                  </div>
          </div>
             <div class="col-md-5ths col-xs-6 col-sm-12  float-left flotablediv">
              <div class="widgetblock chartheight chartbg">
                   <span class="labelwid">NO. OF MINERS VS TIME</span>
                  <div id="myChart7">
                     <canvas></canvas>
                     </div>
                  
                  </div>
          </div>
               <div class="col-md-5ths col-xs-6 col-sm-12  float-left flotablediv">
              <div class="widgetblock chartheight chartbg">
                   <span class="labelwid">AVG TRANSACTION VS TIME</span>
                  <div id="myChart8">
                     <canvas></canvas>
                     </div>
                  
                  </div>
          </div>
               <div class="col-md-5ths col-xs-6 col-sm-12 float-left flotablediv">
              <div class="widgetblock chartheight chartbg">
                   <span class="labelwid">MEDIAN FEE VS TIME</span>
                 <div id="myChart9">
                     <canvas></canvas>
                     </div>
                  
                  </div>
          </div>
              
          
          </div></div>
          
          <div class="row">
          
          <div class="col-md-12 col-sm-12 col-lg-12">
              <div class="widgetheading col-md-12 border-right chartheader">&nbsp;</div>
          <div class="col-md-5ths col-xs-6 col-sm-12  float-left flotablediv">
              <div class="widgetblock chartheight chartbg">
                  <span class="labelwid">RECORDS VS NO. OF BLOCKS</span>
                   <div id="myChart10">
                     <canvas></canvas>
                     </div>
                  </div>
          </div>
             <div class="col-md-5ths col-xs-6 col-sm-12 float-left flotablediv">
              <div class="widgetblock chartheight chartbg">
                  <span class="labelwid">AVG RECORDS VS TIME</span>
                  <div id="myChart11">
                     <canvas></canvas>
                     </div>
                  </div>
          </div>
             <div class="col-md-5ths col-xs-6 col-sm-12  float-left flotablediv">
              <div class="widgetblock chartheight chartbg">
                   <span class="labelwid">AVG DATA VS TIME</span>
                 <div id="myChart12">
                     <canvas></canvas>
                     </div>
                  
                  </div>
          </div>
               <div class="col-md-5ths col-xs-6 col-sm-12  float-left flotablediv">
              <div class="widgetblock chartheight chartbg">
                  <span class="labelwid">DATA VS NO. OF BLOCKS</span>
                  <div id="myChart13">
                     <canvas></canvas>
                     </div>
                  </div>
          </div>
               <div class="col-md-5ths col-xs-6 col-sm-12 float-left flotablediv">
              <div class="widgetblock chartheight chartbg">
                  <span class="labelwid">MEDIAN BLOCK SIZE</span>
                  <div id="myChart14">
                     <canvas></canvas>
                     </div>
                  </div>
          </div>
              
          
          </div></div>
         <div class="clearfix"></div>
          <div class="table100 ver3 m-b-110">
					<div class="table100-head">
						<table>
							<thead>
								<tr class="row100 head">
									<th class="cell100 column1"><img src="images/tableicon1.svg"></th>
									<th class="cell100 column2"><img src="images/tableicon2.svg"></th>
									<th class="cell100 column3"><img src="images/tableicon3.svg"></th>
									<th class="cell100 column4"><img src="images/tableicon_7.svg"></th>
									<th class="cell100 column5"><img src="images/tableicon_11.svg"></th>
                                    <th class="cell100 column5"><img src="images/tableicon4.svg"></th>
                                    <th class="cell100 column5"><img src="images/tableicon5.svg"></th>
								</tr>
                                <tr class="row100 head namingheding">
									<th class="cell100 column1">Miner Name</th>
									<th class="cell100 column2">Miner Address</th>
									<th class="cell100 column3">Block Mined Time</th>
									<th class="cell100 column4">Block No.</th>
									<th class="cell100 column5">TX Id</th>
                                    <th class="cell100 column5">Total Fees</th>
                                    <th class="cell100 column5">Diffculty</th>
								</tr>
							</thead>
                            <tbody id="table-data-all">
								<tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr>
                                <tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr>
                                <tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr><tr class="row100 body">
									<td class="cell100 column1">exp</td>
									<td class="cell100 column2">mpC8A8Fob9ADZQA7iLrctKtwzyWTx118Q9</td>
									<td class="cell100 column3">04 May 2018 01:00:25</td>
									<td class="cell100 column4">213071</td>
									<td class="cell100 column5">abf54b0b9f4acbb53b583b1bccf24194eb7320053c05b2d65b2ade33e23b1f79</td>
                                    <td class="cell100 column5">0</td>
                                    <td class="cell100 column5">0.00478685</td>
								</tr>

								
							</tbody>
						</table>
					</div>

					
							
						
					
				</div>
      </div>
   

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/holder.js"></script>
      <script src="js/chart.js"></script>
<!--      <script src="js/zoom.js"></script>-->
      <script src="js/counter.js"></script>
      <script src="js/d3.js"></script>
      <script src="js/topjson.js"></script>
       <script src="js/map.js"></script>
      <script src="js/custom.js"></script>
   
  </body>
</html>
