
/////////////////////////////////
   // Recordskeeper Stats 	  //
  // Shuchi Tyagi			 //
 // Toshblocks innovations  //
/////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////////


$(document).ready(function(){
		 // Animate loader off screen
           $(".se-pre-con").fadeOut("slow");  // fadeout the preloader
           base_url = 'http://35.171.145.239:8080';
           
           setInterval(function() {
                getBlockInfo();
                getPendingTx();
                getAverageTime();
                getChartData();
            }, 10000);

});

function getBlockInfo(){
    $.ajax({
        url: base_url+'/blockInfo',
        type: 'GET',
        dataType: 'json',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Credentials': true,
            'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers': 'Content-Type',
            'Content-Type':'application/json'
        },
        success: function (data, textStatus, xhr) {
            console.log(data);
            jQuery.parseJSON(JSON.stringify(data));
            $("#best_block").html("#"+data[0].data.best_block);
            $("#best_block_time").html(data[0].data.best_block_timestamp);
            $("#xrk_supply").html(data[0].data.xrk_supply/100000000);
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log('Error in Operation',xhr);
        }
    });
}

function getPendingTx(){
    var body = {'network':localStorage.network};
    $.ajax({
        url: base_url+'/pendingTx',
        type: 'POST',
        data:body,
        dataType: 'json',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Credentials': true,
            'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers': 'Content-Type',
            'Content-Type':'application/json'
        },
        success: function (data, textStatus, xhr) {
            console.log(data);
            jQuery.parseJSON(JSON.stringify(data));
            $("#pending_tx_count").html("#"+data.result.size);
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log('Error in Operation',xhr);
        }
    });
}
function getTxCount(){
    $.ajax({
        url: base_url+'/txCount',
        type: 'GET',
        dataType: 'json',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Credentials': true,
            'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers': 'Content-Type',
            'Content-Type':'application/json'
        },
        success: function (data, textStatus, xhr) {
            console.log(data);
            jQuery.parseJSON(JSON.stringify(data));
            $("#tx_count").html("#"+data[0].results.tx);
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log('Error in Operation',xhr);
        }
    });
}

function getAverageTime(){
    $.ajax({
        url: base_url+'/avgTime',
        type: 'GET',
        dataType: 'json',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Credentials': true,
            'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers': 'Content-Type',
            'Content-Type':'application/json'
        },
        success: function (data, textStatus, xhr) {
            console.log(data);
            jQuery.parseJSON(JSON.stringify(data));
            $("#avg_time").html(Math.round(data[0].data.avg_time)+" s");
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log('Error in Operation',xhr);
        }
    });
}

function getChartData(){
    $.ajax({
        url: base_url+'/chart',
        type: 'GET',
        dataType: 'json',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Credentials': true,
            'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers': 'Content-Type',
            'Content-Type':'application/json'
        },
        success: function (data, textStatus, xhr) {
            console.log(data);
            plotCharts(jQuery.parseJSON(JSON.stringify(data)));
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log('Error in Operation',xhr);
        }   
    });
}

function plotCharts(values){
    var rates = [];
    var difficulty = [];
    var timestamp = [];
    var date;

    for(var i=0; i<values[0].data.results.length; i++)
    {
        rates.push(values[0].data.results[i].hash_rate);
        difficulty.push(values[0].data.results[i].difficulty);
        date = new Date(values[0].data.results[i].created_at);
        timestamp.push(date.getDate());
    }

    var ctx = $("#hashChart");
    let chart = new Chart(ctx, {
        type: 'line',
        data: {
            datasets: [{
                label: 'Hash Rates',
                data: rates,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }],
            labels: timestamp
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        suggestedMin: 0.000150,
                        suggestedMax: 0.000225
                    }
                }]
            }
        }
    });

    var diffctx = $("#diffChart");
    let diffChart = new Chart(diffctx, {
        type: 'line',
        data: {
            datasets: [{
                label: 'Difficulty',
                data: difficulty,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }],
            labels: timestamp
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        suggestedMin: 0.001,
                        suggestedMax: 0.005
                    }
                }]
            }
        }
    });
}
