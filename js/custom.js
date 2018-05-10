

$('#checkboxnetwork').click(function(e){
    if ($(this).prop("checked")){
        $('.labelnetwrk').text('Main Network');
        $('body').attr('data-url','main');
        $('body').removeClass('main');
     }  
    else{
        $('.labelnetwrk').text('Test Network');
          $('body').attr('data-url','alldata');
          $('body').addClass('main');
    }
    $('body').clearQueue();
    fixedvaluedata();
    dunamicvalue();
averagedatavalueblockchain();
medianblockvalue();
geomapondata();
    transactioncount();
    bestblocknumber(); 
    avgdatapublished();
    avgdatadifficulty();
    avgdatahashrate();
    avgblocktimedata();
    transactionvsblock();
    medianfeesvsblock();
diffcultyvsblock();
hashvstimedata();
minersvstimedata();
transactionvstimedata();
medianfeessvstimedata();
recordssvsblock();
recordsavgvstimedata();
datasizevstimedata();
datasizevsblocksdata();
medianblocksizechart();
medianblocksizechart();
tablealldatefill();
})

//// fixed value function //////////////////////
function fixedvaluedata(){   
     var url = $('body').attr('data-url');
    $.ajax({
        type: "POST", 
        url: ""+url+".php?fixedvalue",
        dataType:"text", 
        data:0, 
        success:function(response){
            var data = $.parseJSON(response);
            $('body').find('#maxtransactionsize').text(data['max_tx_size']);
            $('body').find('#maxblocksize').text(data['max_block_size']);
            $('body').find('#transactionfess').text(data['fee']);
            
        }
     }); 
}

//// dunamic value function //////////////////////
function dunamicvalue(){  
     var url = $('body').attr('data-url');
    $.ajax({
        type: "POST", 
        url: ""+url+".php?dynamicvalue",
        dataType:"text", 
        data:0, 
        success:function(response){
            var data = $.parseJSON(response);
           $('body').find('#totalxrxsupply').text(data['xrk_supply']);
            $('body').find('#activeminers').text(data['active_miners']);
            $('body').find('#pendingtransaction').text(data['pending_tx']);
            $('body').find('#totaladdress').text(data['total_addresses']);
           
           
           
        }
     }); 
}

//// median block function //////////////////////
function medianblockvalue(){   
     var url = $('body').attr('data-url');
    $.ajax({
        type: "POST", 
        url: ""+url+".php?medianblocksize",
        dataType:"text", 
        data:0, 
        success:function(response){
            //var data = $.parseJSON(response);
           $('body').find('#medianblocksize').text((response/1024).toFixed(3));
         }
     }); 
}


//// transaction count value function //////////////////////

function transactioncount(){   
      var url = $('body').attr('data-url');
    $.ajax({
        type: "POST", 
        url: ""+url+".php?totaltransactioncount",
        dataType:"text", 
        data:0, 
        success:function(response){
            var data = $.parseJSON(response);
             var avgtime = $('body').data('averagetime');
             $('body').find('#totaltransaction').text(data['txcnt']);  
             $('body').find('#totalrecordspublish').text(data['records']);
             $('body').find('#averagerecordpublish').text((data['records']/(data['block']*avgtime)).toFixed(5));
             $('body').find('#avgperblockrecords').text((data['records']/data['block']).toFixed(3));
            
            
            
            
            
           
        }
     }); 
}


//// best block value function //////////////////////

function bestblocknumber(){   
     var url = $('body').attr('data-url');
    $.ajax({
        type: "POST", 
        url: ""+url+".php?bestblocknumber",
        dataType:"text", 
        data:0, 
        success:function(response){
            var data = $.parseJSON(response);
           $('body').find('#bestblocknumber').text(data['best_block']);   
           $('body').find('#lastcreatedblock').text(data['time_diff']);
           
        }
     }); 
}


//// avg data publisghed //////////////////////

function avgdatapublished(){  
      var url = $('body').attr('data-url');
    $.ajax({
        type: "POST", 
        url: ""+url+".php?avgdatapublish",
        dataType:"text", 
        data:0, 
        success:function(response){
            var data = $.parseJSON(response);
            var avgtime = $('body').data('averagetime');
           $('body').find('#averagedatapublished').text((data['size']/(data['block']*avgtime)).toFixed(4));   
           $('body').find('#avgdatepublishperblock').text((data['size']/data['block']).toFixed(4));
           
        }
     }); 
}


//// chart data difficult //////////////////////

function avgdatadifficulty(){ 
     var url = $('body').attr('data-url');
var arr = [];
var arr1 = [];
    $.ajax({
        type: "POST", 
        url: ""+url+".php?chartdifficultdata",
        dataType:"text", 
        data:0, 
        success:function(response){
            var i = 0;
            var data = $.parseJSON(response);
            var length = data.length;
            for(i=0;i<length;i++){
                arr.push(data[i].block); 
                arr1.push((data[i].diff)*1); 
            }
            $('#myChart').html('');
            $('<canvas></canvas>').appendTo('#myChart');
          var ctx = $('#myChart canvas');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: { labels: arr,
        datasets: [{
            data: arr1,
            backgroundColor: ['#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3']
        }]
    },
    options: {
        animation: {
        duration: 0
    },
        tooltips: {
         enabled: true
    },
        legend: {display: false},
         scales: {
        yAxes: [{ticks: {beginAtZero: true,display: false},
        gridLines: {display:false},
                 //beginAtZero: true ,
        }],
            xAxes: [{
            ticks: {display: false},
                gridLines: {
                    display:false
                },
        }]
    },
    }
});
            
   }
     }); 
}

/// chart data hash //////////////////////

function avgdatahashrate(){ 
      var url = $('body').attr('data-url');
var arr2 = [];
var arr3 = [];
    $.ajax({
        type: "POST", 
        url: ""+url+".php?charthasgratedata",
        dataType:"text", 
        data:0, 
        success:function(response){
            var i = 0;
            var data = $.parseJSON(response);
            var length = data.length;
            for(i=0;i<length;i++){
                arr2.push(data[i].block); 
                arr3.push((data[i].hash)*1); 
            }
             $('#myChart1').html('');
            $('<canvas></canvas>').appendTo('#myChart1');
          var ctx1 = $('#myChart1 canvas');
var myChart1 = new Chart(ctx1, {
    type: 'bar',
    data: { labels: arr2,
        datasets: [{
            data: arr3,
            backgroundColor: ['#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3']
        }]
    },
    options: {
        animation: {
        duration: 0
    },
        tooltips: {
         enabled: true
    },
        legend: {display: false},
         scales: {
        yAxes: [{ticks: {beginAtZero: true,display: false},
        gridLines: {display:false},
                 //beginAtZero: true ,
        }],
            xAxes: [{
            ticks: {display: false},
                gridLines: {
                    display:false
                },
        }]
    },
    }
});

}
    });
}

/// avg block time  //////////////////////

function avgblocktimedata(){ 
     var url = $('body').attr('data-url');
var arr4 = [];
var arr5 = [];
    $.ajax({
        type: "POST", 
       url: ""+url+".php?averageblocktimedata",
        dataType:"text", 
        data:0, 
        success:function(response){
            var i = 0;
            var data = $.parseJSON(response);
            var length = data.length;
            for(i=0;i<length;i++){
              
                arr4.push(data[i].block); 
                arr5.push(data[i].avgtime); 
            }
$('#myChart2').html('');
            $('<canvas></canvas>').appendTo('#myChart2');
          var ctx2 = $('#myChart2 canvas');
var myChart2 = new Chart(ctx2, {
  type: 'line',
  data: {
   labels: arr4,
    datasets: [ { 
        data: arr5,
        backgroundColor: ['#2fc56a']
						//borderColor: presets.red,
						//data: generateData(),
						//label: 'Dataset',
						//fill: boundary
      }
    ]
  },
   options: {
       animation: {
        duration: 0
    },
       elements: {
				line: {
					tension: 0
				}
			},
        legend: {
    	display: false
        },
//        title: {
//            display: true,
//            text: 'Custom Chart Title',
//            
//        },
         scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true,
                display: false
            },
            gridLines: {
                    display:false
                }
        }],
            xAxes: [{
            ticks: {
                display: false
            },
                gridLines: {
                    display:false
                },
        }]
    },
//        pan: {
//            enabled: true,
//            mode: 'x'
//        },
//        zoom: {
//            enabled: true,
//            mode: 'x',
//        }
    }
});


}
    });
}

/// transactin vs block

function transactionvsblock(){ 
      var url = $('body').attr('data-url');
var arr6 = [];
var arr7 = [];
    $.ajax({
        type: "POST", 
        url: ""+url+".php?transactionvsblock",
        dataType:"text", 
        data:0, 
        success:function(response){
            var i = 0;
            var data = $.parseJSON(response);
            var length = data.length;
            for(i=0;i<length;i++){
                arr6.push(data[i].block); 
                arr7.push((data[i].count)); 
            }
        $('#myChart3').html('');
            $('<canvas></canvas>').appendTo('#myChart3');
          var ctx3 = $('#myChart3 canvas');
var myChart3 = new Chart(ctx3, {
    type: 'bar',
    data: { labels: arr6,
        datasets: [{
            data: arr7,
            backgroundColor: ['#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3']
        }]
    },
    options: {
        animation: {
        duration: 0
    },
        tooltips: {
         enabled: true
    },
        legend: {display: false},
         scales: {
        yAxes: [{ticks: {beginAtZero: true,display: false},
                  
        gridLines: {display:false},
                 //type: 'logarithmic',
                 //beginAtZero: true ,
        }],
            xAxes: [{
            ticks: {display: false},
                gridLines: {
                    display:false
                },
        }]
    },
    }
});

}
    });
}

////////////medianfees vs block

function medianfeesvsblock(){ 
      var url = $('body').attr('data-url');
var arr8 = [];
var arr9 = [];
    $.ajax({
        type: "POST", 
        url: ""+url+".php?medianfeesblock",
        dataType:"text", 
        data:0, 
        success:function(response){
            var i = 0;
            var data = $.parseJSON(response);
            var length = data.length;
            for(i=0;i<length;i++){
                arr8.push(data[i].block); 
                arr9.push((data[i].fees)); 
            }
            
         $('#myChart4').html('');
            $('<canvas></canvas>').appendTo('#myChart4');
          var ctx4 = $('#myChart4 canvas');
          
var myChart4 = new Chart(ctx4, {
    type: 'bar',
    data: { labels: arr8,
        datasets: [{
            data: arr9,
            backgroundColor: ['#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3']
        }]
    },
    options: {
        animation: {
        duration: 0
    },
        tooltips: {
         enabled: true
    },
        legend: {display: false},
         scales: {
        yAxes: [{ticks: {beginAtZero: true,display: false},
                  
        gridLines: {display:false},
                 //type: 'logarithmic',
                 //beginAtZero: true ,
        }],
            xAxes: [{
            ticks: {display: false},
                gridLines: {
                    display:false
                },
        }]
    },
    }
});
            
 
}
    });
}

///////////// diffulcty vs time


function diffcultyvsblock(){ 
      var url = $('body').attr('data-url');
var arr8 = [];
var arr9 = [];
    $.ajax({
        type: "POST", 
        url: ""+url+".php?diffcultyvstimechart",
        dataType:"text", 
        data:0, 
        success:function(response){
            var i = 0;
            var data = $.parseJSON(response);
            var length = data.length;
            for(i=0;i<length;i++){
                arr8.push(data[i].time); 
                arr9.push((data[i].diff)); 
            }
            
         $('#myChart5').html('');
            $('<canvas></canvas>').appendTo('#myChart5');
          var ctx5 = $('#myChart5 canvas');
          
var myChart5 = new Chart(ctx5, {
    type: 'bar',
    data: { labels: arr8,
        datasets: [{
            data: arr9,
            backgroundColor: ['#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3']
        }]
    },
    options: {
        animation: {
        duration: 0
    },
        tooltips: {
         enabled: true
    },
        legend: {display: false},
         scales: {
        yAxes: [{ticks: {beginAtZero: true,display: false},
                  
        gridLines: {display:false},
                 //type: 'logarithmic',
                 //beginAtZero: true ,
        }],
            xAxes: [{
            ticks: {display: false},
                gridLines: {
                    display:false
                },
        }]
    },
    }
});
            
 
}
    });
}

///////////hash vs time

function hashvstimedata(){ 
      var url = $('body').attr('data-url');
var arr4 = [];
var arr5 = [];
    $.ajax({
        type: "POST", 
        url: ""+url+".php?hasratevstimechart",
        dataType:"text", 
        data:0, 
        success:function(response){
            var i = 0;
            var data = $.parseJSON(response);
            var length = data.length;
            for(i=0;i<length;i++){
              
                arr4.push(data[i].time); 
                arr5.push(data[i].hash); 
            }
$('#myChart6').html('');
            $('<canvas></canvas>').appendTo('#myChart6');
          var ctx6 = $('#myChart6 canvas');
var myChart6 = new Chart(ctx6, {
  type: 'line',
  data: {
   labels: arr4,
    datasets: [ { 
        data: arr5,
        backgroundColor: ['#2fc56a']
						//borderColor: presets.red,
						//data: generateData(),
						//label: 'Dataset',
						//fill: boundary
      }
    ]
  },
   options: {
       animation: {
        duration: 0
    },
       elements: {
				line: {
					tension: 0
				}
			},
        legend: {
    	display: false
        },
//        title: {
//            display: true,
//            text: 'Custom Chart Title',
//            
//        },
         scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true,
                display: false
            },
            gridLines: {
                    display:false
                }
        }],
            xAxes: [{
            ticks: {
                display: false
            },
                gridLines: {
                    display:false
                },
        }]
    },
//        pan: {
//            enabled: true,
//            mode: 'x'
//        },
//        zoom: {
//            enabled: true,
//            mode: 'x',
//        }
    }
});


}
    });
}

///////////miner vs time

function minersvstimedata(){ 
      var url = $('body').attr('data-url');
var arr4 = [];
var arr5 = [];
    $.ajax({
        type: "POST", 
        url: ""+url+".php?minersvstimechart",
        dataType:"text", 
        data:0, 
        success:function(response){
            var i = 0;
            var data = $.parseJSON(response);
            var length = data.length;
            for(i=0;i<length;i++){
              
                arr4.push(data[i].time); 
                arr5.push(data[i].miners); 
            }
$('#myChart7').html('');
            $('<canvas></canvas>').appendTo('#myChart7');
          var ctx7 = $('#myChart7 canvas');
var myChart7 = new Chart(ctx7, {
  type: 'line',
  data: {
   labels: arr4,
    datasets: [ { 
        data: arr5,
        backgroundColor: ['#2fc56a']
						//borderColor: presets.red,
						//data: generateData(),
						//label: 'Dataset',
						//fill: boundary
      }
    ]
  },
   options: {
       animation: {
        duration: 0
    },
       elements: {
				line: {
					tension: 0
				}
			},
        legend: {
    	display: false
        },
//        title: {
//            display: true,
//            text: 'Custom Chart Title',
//            
//        },
         scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true,
                display: false
            },
            gridLines: {
                    display:false
                }
        }],
            xAxes: [{
            ticks: {
                display: false
            },
                gridLines: {
                    display:false
                },
        }]
    },
//        pan: {
//            enabled: true,
//            mode: 'x'
//        },
//        zoom: {
//            enabled: true,
//            mode: 'x',
//        }
    }
});


}
    });
}

///////////transaction vs time

function transactionvstimedata(){ 
      var url = $('body').attr('data-url');
var arr4 = [];
var arr5 = [];
    $.ajax({
        type: "POST", 
        url: ""+url+".php?transactionvstimechart",
        dataType:"text", 
        data:0, 
        success:function(response){
            var i = 0;
            var data = $.parseJSON(response);
            var length = data.length;
            for(i=0;i<length;i++){
              
                arr4.push(data[i].time); 
                arr5.push(data[i].txn); 
            }
$('#myChart8').html('');
            $('<canvas></canvas>').appendTo('#myChart8');
          var ctx8 = $('#myChart8 canvas');
var myChart8 = new Chart(ctx8, {
  type: 'line',
  data: {
   labels: arr4,
    datasets: [ { 
        data: arr5,
        backgroundColor: ['#2fc56a']
						//borderColor: presets.red,
						//data: generateData(),
						//label: 'Dataset',
						//fill: boundary
      }
    ]
  },
   options: {
       animation: {
        duration: 0
    },
       elements: {
				line: {
					tension: 0
				}
			},
        legend: {
    	display: false
        },
//        title: {
//            display: true,
//            text: 'Custom Chart Title',
//            
//        },
         scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true,
                display: false
            },
            gridLines: {
                    display:false
                }
        }],
            xAxes: [{
            ticks: {
                display: false
            },
                gridLines: {
                    display:false
                },
        }]
    },
//        pan: {
//            enabled: true,
//            mode: 'x'
//        },
//        zoom: {
//            enabled: true,
//            mode: 'x',
//        }
    }
});


}
    });
}

///////////transaction vs time

function medianfeessvstimedata(){ 
      var url = $('body').attr('data-url');
var arr4 = [];
var arr5 = [];
    $.ajax({
        type: "POST", 
        url: ""+url+".php?mfeesvstimechart",
        dataType:"text", 
        data:0, 
        success:function(response){
            var i = 0;
            var data = $.parseJSON(response);
            var length = data.length;
            for(i=0;i<length;i++){
              
                arr4.push(data[i].time); 
                arr5.push(data[i].fees); 
            }
$('#myChart9').html('');
            $('<canvas></canvas>').appendTo('#myChart9');
          var ctx9 = $('#myChart9 canvas');
var myChart9 = new Chart(ctx9, {
  type: 'line',
  data: {
   labels: arr4,
    datasets: [ { 
        data: arr5,
        backgroundColor: ['#2fc56a']
						//borderColor: presets.red,
						//data: generateData(),
						//label: 'Dataset',
						//fill: boundary
      }
    ]
  },
   options: {
       animation: {
        duration: 0
    },
       elements: {
				line: {
					tension: 0
				}
			},
        legend: {
    	display: false
        },
//        title: {
//            display: true,
//            text: 'Custom Chart Title',
//            
//        },
         scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true,
                display: false
            },
            gridLines: {
                    display:false
                }
        }],
            xAxes: [{
            ticks: {
                display: false
            },
                gridLines: {
                    display:false
                },
        }]
    },
//        pan: {
//            enabled: true,
//            mode: 'x'
//        },
//        zoom: {
//            enabled: true,
//            mode: 'x',
//        }
    }
});


}
    });
}

////////////records vs block

function recordssvsblock(){ 
      var url = $('body').attr('data-url');
var arr8 = [];
var arr9 = [];
    $.ajax({
        type: "POST", 
        url: ""+url+".php?recordvsblockchart",
        dataType:"text", 
        data:0, 
        success:function(response){
            var i = 0;
            var data = $.parseJSON(response);
            var length = data.length;
            for(i=0;i<length;i++){
                arr8.push(data[i].block); 
                arr9.push((data[i].item)); 
            }
            
        $('#myChart10').html('');
            $('<canvas></canvas>').appendTo('#myChart10');
          var ctx10 = $('#myChart10 canvas');
          
var myChart10 = new Chart(ctx10, {
    type: 'bar',
    data: { labels: arr8,
        datasets: [{
            data: arr9,
            backgroundColor: ['#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3','#2fc56a','#c646b3']
        }]
    },
    options: {
        animation: {
        duration: 0
    },
        tooltips: {
         enabled: true
    },
        legend: {display: false},
         scales: {
        yAxes: [{ticks: {beginAtZero: true,display: false},
                  
        gridLines: {display:false},
                 //type: 'logarithmic',
                 //beginAtZero: true ,
        }],
            xAxes: [{
            ticks: {display: false},
                gridLines: {
                    display:false
                },
        }]
    },
    }
});
            
 
}
    });
}


///////////records vs time

function recordsavgvstimedata(){ 
      var url = $('body').attr('data-url');
var arr4 = [];
var arr5 = [];
    $.ajax({
        type: "POST", 
        url: ""+url+".php?recordsavgvstimedatachart",
        dataType:"text", 
        data:0, 
        success:function(response){
            var i = 0;
            var data = $.parseJSON(response);
            var length = data.length;
            for(i=0;i<length;i++){
              
                arr4.push(data[i].time); 
                arr5.push(data[i].items); 
            }
$('#myChart11').html('');
            $('<canvas></canvas>').appendTo('#myChart11');
          var ctx11 = $('#myChart11 canvas');
var myChart11 = new Chart(ctx11, {
  type: 'line',
  data: {
   labels: arr4,
    datasets: [ { 
        data: arr5,
        backgroundColor: ['#2fc56a']
						//borderColor: presets.red,
						//data: generateData(),
						//label: 'Dataset',
						//fill: boundary
      }
    ]
  },
   options: {
       animation: {
        duration: 0
    },
       elements: {
				line: {
					tension: 0
				}
			},
        legend: {
    	display: false
        },
//        title: {
//            display: true,
//            text: 'Custom Chart Title',
//            
//        },
         scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true,
                display: false
            },
            gridLines: {
                    display:false
                }
        }],
            xAxes: [{
            ticks: {
                display: false
            },
                gridLines: {
                    display:false
                },
        }]
    },
//        pan: {
//            enabled: true,
//            mode: 'x'
//        },
//        zoom: {
//            enabled: true,
//            mode: 'x',
//        }
    }
});


}
    });
}


///////////datasize vs time

function datasizevstimedata(){ 
      var url = $('body').attr('data-url');
var arr4 = [];
var arr5 = [];
    $.ajax({
        type: "POST", 
        url: ""+url+".php?datasizevstimedatachart",
        dataType:"text", 
        data:0, 
        success:function(response){
            var i = 0;
            var data = $.parseJSON(response);
            var length = data.length;
            for(i=0;i<length;i++){
              
                arr4.push(data[i].time); 
                arr5.push(data[i].size); 
            }
$('#myChart12').html('');
            $('<canvas></canvas>').appendTo('#myChart12');
          var ctx12 = $('#myChart12 canvas');
var myChart12 = new Chart(ctx12, {
  type: 'line',
  data: {
   labels: arr4,
    datasets: [ { 
        data: arr5,
        backgroundColor: ['#2fc56a']
						//borderColor: presets.red,
						//data: generateData(),
						//label: 'Dataset',
						//fill: boundary
      }
    ]
  },
   options: {
       animation: {
        duration: 0
    },
       elements: {
				line: {
					tension: 0
				}
			},
        legend: {
    	display: false
        },
//        title: {
//            display: true,
//            text: 'Custom Chart Title',
//            
//        },
         scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true,
                display: false
            },
            gridLines: {
                    display:false
                }
        }],
            xAxes: [{
            ticks: {
                display: false
            },
                gridLines: {
                    display:false
                },
        }]
    },
//        pan: {
//            enabled: true,
//            mode: 'x'
//        },
//        zoom: {
//            enabled: true,
//            mode: 'x',
//        }
    }
});


}
    });
}

//// datasize vs block

function datasizevsblocksdata(){ 
      var url = $('body').attr('data-url');
var arr4 = [];
var arr5 = [];
    $.ajax({
        type: "POST", 
        url: ""+url+".php?datasizevsblockdatachart",
        dataType:"text", 
        data:0, 
        success:function(response){
            var i = 0;
            var data = $.parseJSON(response);
            var length = data.length;
            for(i=0;i<length;i++){
              
                arr4.push(data[i].block); 
                arr5.push(data[i].size); 
            }
$('#myChart13').html('');
            $('<canvas></canvas>').appendTo('#myChart13');
          var ctx13 = $('#myChart13 canvas');
var myChart13 = new Chart(ctx13, {
  type: 'line',
  data: {
   labels: arr4,
    datasets: [ { 
        data: arr5,
        backgroundColor: ['#2fc56a']
						//borderColor: presets.red,
						//data: generateData(),
						//label: 'Dataset',
						//fill: boundary
      }
    ]
  },
   options: {
       animation: {
        duration: 0
    },
       elements: {
				line: {
					tension: 0
				}
			},
        legend: {
    	display: false
        },
//        title: {
//            display: true,
//            text: 'Custom Chart Title',
//            
//        },
         scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true,
                display: false
            },
            gridLines: {
                    display:false
                }
        }],
            xAxes: [{
            ticks: {
                display: false
            },
                gridLines: {
                    display:false
                },
        }]
    },
//        pan: {
//            enabled: true,
//            mode: 'x'
//        },
//        zoom: {
//            enabled: true,
//            mode: 'x',
//        }
    }
});


}
    });
}


//// datasize vs block

function medianblocksizechart(){ 
      var url = $('body').attr('data-url');
var arr4 = [];
var arr5 = [];
    $.ajax({
        type: "POST", 
        url: ""+url+".php?medianblocksizechart",
        dataType:"text", 
        data:0, 
        success:function(response){
            var i = 0;
            var data = $.parseJSON(response);
            var length = data.length;
            for(i=0;i<length;i++){
              
                arr4.push(data[i].block); 
                arr5.push(data[i].size); 
            }
$('#myChart14').html('');
            $('<canvas></canvas>').appendTo('#myChart14');
          var ctx14 = $('#myChart14 canvas');
var myChart14 = new Chart(ctx14, {
  type: 'line',
  data: {
   labels: arr4,
    datasets: [ { 
        data: arr5,
        backgroundColor: ['#2fc56a']
						//borderColor: presets.red,
						//data: generateData(),
						//label: 'Dataset',
						//fill: boundary
      }
    ]
  },
   options: {
       animation: {
        duration: 0
    },
       elements: {
				line: {
					tension: 0
				}
			},
        legend: {
    	display: false
        },
//        title: {
//            display: true,
//            text: 'Custom Chart Title',
//            
//        },
         scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true,
                display: false
            },
            gridLines: {
                    display:false
                }
        }],
            xAxes: [{
            ticks: {
                display: false
            },
                gridLines: {
                    display:false
                },
        }]
    },
//        pan: {
//            enabled: true,
//            mode: 'x'
//        },
//        zoom: {
//            enabled: true,
//            mode: 'x',
//        }
    }
});


}
    });
}

////    all table data fill 

function tablealldatefill(){ 
  var url = $('body').attr('data-url');
        //$('body').find('#table-data-all').html('');
    $.ajax({
        type: "POST", 
       url: ""+url+".php?tabledataforminers",
        dataType:"text", 
        data:0, 
        success:function(response){
            var i = 0;
             var k = 1;
            var data = $.parseJSON(response);
            var length = data.length;
          for(i=0;i<length;i++){
                var tablrow = $('body').find('#table-data-all tr')[i];
                $(tablrow).find('td:nth-child(1)').text(data[i].name); 
                $(tablrow).find('td:nth-child(2)').text(data[i].address); 
                $(tablrow).find('td:nth-child(3)').text(data[i].time); 
                $(tablrow).find('td:nth-child(4)').text(data[i].block); 
                $(tablrow).find('td:nth-child(5)').text(data[i].txid); 
                $(tablrow).find('td:nth-child(6)').text(data[i].fees); 
                $(tablrow).find('td:nth-child(7)').text(data[i].diff); 
           }
}
    });
}


var bombMap = new Datamap({
    element: document.getElementById('map_bombs'),
    scope: 'world',
    geographyConfig: {
        popupOnHover: false,
        highlightOnHover: false
    },
    fills: {
       defaultFill: '#605779'
    }
});
function geomapondata(){
    $('#map_bombs').find('circle').remove();
     var url = $('body').attr('data-url');
    var datamap = [];
   $.ajax({
        type: "POST", 
        url: ""+url+".php?mapdataminersall",
        dataType:"text", 
        data:0, 
        success:function(response){
            var i = 0;
            var data = $.parseJSON(response);
//            var length = data.length;
//            
//             for(i=0;i<length;i++){
//                 
//             }


     var bombs = data;
            
//draw bubbles for bombs
bombMap.bubbles(bombs, {
    popupTemplate: function (geo, data) {
            return ['<div class="hoverinfo">Ip: ' +  data.ip,
            '<br/>Country: ' +  data.country + '',
            '</div>'].join('');
    }
});

}
    });
}

/// average time block calculated

function averagedatavalueblockchain(){ 
     var url = $('body').attr('data-url');
    $.ajax({
        type: "POST", 
        url: ""+url+".php?averagedatavaluueblock",
        dataType:"text", 
        data:0, 
        success:function(response){
            var data = $.parseJSON(response);
            $('body').find('#avgblocktimeall').text((response/1).toFixed(0));
            $('body').attr('data-averagetime',((response/1).toFixed(0)));
        }
     }); 
}



///////////////////// function calling method
    

fixedvaluedata();
    dunamicvalue();
averagedatavalueblockchain();
medianblockvalue();
geomapondata();
    transactioncount();
    bestblocknumber(); 
    avgdatapublished();
    avgdatadifficulty();
    avgdatahashrate();
    avgblocktimedata();
    transactionvsblock();
    medianfeesvsblock();
diffcultyvsblock();
hashvstimedata();
minersvstimedata();
transactionvstimedata();
medianfeessvstimedata();
recordssvsblock();
recordsavgvstimedata();
datasizevstimedata();
datasizevsblocksdata();
medianblocksizechart();
medianblocksizechart();
tablealldatefill();

setInterval(function(){ 
    fixedvaluedata();
    dunamicvalue();
     geomapondata();
    medianblockvalue();
    averagedatavalueblockchain();
    transactioncount();
    bestblocknumber(); 
    avgdatapublished();
    avgdatadifficulty();
    avgdatahashrate();
    avgblocktimedata();
    transactionvsblock();
    medianfeesvsblock();
    diffcultyvsblock();
    hashvstimedata();
    minersvstimedata();
    transactionvstimedata();
    medianfeessvstimedata();
    recordssvsblock();
    recordsavgvstimedata();
    datasizevstimedata();
    datasizevsblocksdata();
    medianblocksizechart();
    medianblocksizechart();
    tablealldatefill();
   
}, 13000);




///counter 
var counter = 0;
setInterval(function () {
   counter = $('body').find('#lastcreatedblock').text();
  ++counter;
    $('body').find('#lastcreatedblock').text(counter);
}, 1000);



