
/////////////////////////////////
   // Recordskeeper Stats 	  //
  // Shuchi Tyagi			 //
 // Toshblocks innovations  //
/////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////////


$(document).ready(function(){
		 // Animate loader off screen
           $(".se-pre-con").fadeOut("slow");  // fadeout the preloader
           
           setInterval(function() {
                getBlockInfo();
                getPendingTx();
                getAverageTime();
                getChartData();
            }, 10000);

});

function getBlockInfo(){
    $.ajax({
        url: 'http://test-stats.recordskeeper.co/api/blockInfo',
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
    $.ajax({
        url: 'http://test-stats.recordskeeper.co/api/pendingTx',
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
            $("#pending_tx_count").html("#"+data.result.size);
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log('Error in Operation',xhr);
            // var data = {
            //     "result": {
            //         "size": 0,
            //         "bytes": 0
            //     },
            //     "error": null,
            //     "id": 1
            // };
            // jQuery.parseJSON(JSON.stringify(data));
            // $("#pending_tx_count").html("#"+data.result.size);
        }
    });
}
function getTxCount(){
    $.ajax({
        url: 'http://test-stats.recordskeeper.co/api/txCount',
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
            // var data = [
            //     {
            //         "status": "success",
            //         "data": {
            //             "results": [
            //                 {
            //                     "id": 5,
            //                     "tx": 21711,
            //                     "txin": 43185,
            //                     "txout": 42543,
            //                     "block": 21026,
            //                     "created_at": "2018-02-24T08:58:49.000Z"
            //                 }
            //             ]
            //         }
            //     }
            // ];
            // jQuery.parseJSON(JSON.stringify(data));
            // $("#tx_count").html("#"+data[0].results.tx);
        }
    });
}

function getAverageTime(){
    $.ajax({
        url: 'http://test-stats.recordskeeper.co/api/avgTime',
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
            // var data = [{
            //     "status": "success",
            //     "data": {
            //         "avg_time": 35.05858310626703
            //     }
            // }];
            // jQuery.parseJSON(JSON.stringify(data));
            // $("#avg_time").html(Math.round(data[0].data.avg_time)+" s");
        }
    });
}

function getChartData(){
    $.ajax({
        url: 'http://test-stats.recordskeeper.co/api/chart',
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
            // var data = [{
            //     "status": "success",
            //     "data": {
            //         "results": [{
            //             "id": 35,
            //             "difficulty": 0.00781238,
            //             "hash_rate": 0.000223210857142857,
            //             "created_at": "2018-02-24T14:40:04.000Z"
            //         }, {
            //             "id": 34,
            //             "difficulty": 0.00781238,
            //             "hash_rate": 0.000223210857142857,
            //             "created_at": "2018-02-24T14:35:03.000Z"
            //         }, {
            //             "id": 33,
            //             "difficulty": 0.00781238,
            //             "hash_rate": 0.0002232999102034402,
            //             "created_at": "2018-02-24T14:30:04.000Z"
            //         }, {
            //             "id": 32,
            //             "difficulty": 0.00781238,
            //             "hash_rate": 0.0002235063111324432,
            //             "created_at": "2018-02-24T14:25:04.000Z"
            //         }, {
            //             "id": 31,
            //             "difficulty": 0.00781238,
            //             "hash_rate": 0.000223210549520294,
            //             "created_at": "2018-02-24T14:20:04.000Z"
            //         }, {
            //             "id": 30,
            //             "difficulty": 0.00781238,
            //             "hash_rate": 0.000223213405932204,
            //             "created_at": "2018-02-24T14:15:04.000Z"
            //         }, {
            //             "id": 29,
            //             "difficulty": 0.00781238,
            //             "hash_rate": 0.00022321085713210,
            //             "created_at": "2018-02-24T14:10:04.000Z"
            //         }]
            //     }
            // }];
            
            // plotCharts(jQuery.parseJSON(JSON.stringify(data)));
            // $("#").html("#"+data[0].data.avg_time);
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
