
/////////////////////////////////
   // Recordskeeper Stats 	  //
  // Shuchi Tyagi			 //
 // Toshblocks innovations  //
/////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////////


$(document).ready(function(){
		 // Animate loader off screen
           $(".se-pre-con").fadeOut("slow");  // fadeout the preloader
           getBlockInfo();
           getPendingTx();
           getAverageTime();

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
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log('Error in Operation',xhr);

            var data = [
                {
                    "status": "success",
                    "data": {
                        "best_block": 20758,
                        "xrk_supply": 5020758000000000,
                        "best_block_timestamp": 1519480950
                    }
                }
            ];
            jQuery.parseJSON(JSON.stringify(data));
            $("#best_block").html("#"+data[0].data.best_block);
            $("#best_block_time").html(data[0].data.best_block_timestamp);
            $("#xrk_supply").html(data[0].data.xrk_supply/100000000);
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
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log('Error in Operation',xhr);
            var data = {
                "result": {
                    "size": 0,
                    "bytes": 0
                },
                "error": null,
                "id": 1
            };
            jQuery.parseJSON(JSON.stringify(data));
            $("#pending_tx").html("#"+data.result.size);
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
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log('Error in Operation',xhr);
            var data = [{
                "status": "success",
                "data": {
                    "avg_time": 35.05858310626703
                }
            }];
            jQuery.parseJSON(JSON.stringify(data));
            $("#avg_time").html("#"+data[0].data.avg_time);
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
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log('Error in Operation',xhr);
            var data = [{
                "status": "success",
                "data": {
                    "results": [{
                        "id": 35,
                        "difficulty": 0.00781238,
                        "hash_rate": 0.000223210857142857,
                        "created_at": "2018-02-24T14:40:04.000Z"
                    }, {
                        "id": 34,
                        "difficulty": 0.00781238,
                        "hash_rate": 0.000223210857142857,
                        "created_at": "2018-02-24T14:35:03.000Z"
                    }, {
                        "id": 33,
                        "difficulty": 0.00781238,
                        "hash_rate": 0.000223210857142857,
                        "created_at": "2018-02-24T14:30:04.000Z"
                    }, {
                        "id": 32,
                        "difficulty": 0.00781238,
                        "hash_rate": 0.000223210857142857,
                        "created_at": "2018-02-24T14:25:04.000Z"
                    }, {
                        "id": 31,
                        "difficulty": 0.00781238,
                        "hash_rate": 0.000223210857142857,
                        "created_at": "2018-02-24T14:20:04.000Z"
                    }, {
                        "id": 30,
                        "difficulty": 0.00781238,
                        "hash_rate": 0.000223210857142857,
                        "created_at": "2018-02-24T14:15:04.000Z"
                    }, {
                        "id": 29,
                        "difficulty": 0.00781238,
                        "hash_rate": 0.000223210857142857,
                        "created_at": "2018-02-24T14:10:04.000Z"
                    }]
                }
            }];
            jQuery.parseJSON(JSON.stringify(data));
            $("#avg_time").html("#"+data[0].data.avg_time);
        }
    });
}

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
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
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
