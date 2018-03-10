var mainNetColor = "#212739";
var testNetColor = "#54b2ce";
var eventStream;

$(document).ready(function(){

    // display network as per cookie
    if(getCookieValue("rk-network") == "test") {
        switchNetwork("test");
    }
    else {
        switchNetwork("main");
    }
    
    resetData();

    $('#cb1').change(function() {
        if(this.checked) {
            switchNetwork("test");
        }
        else {
            switchNetwork("main");
        }
        streamClose();
        resetData();
        location.reload(true);
    });

    // Animate loader off screen
    $(".se-pre-con").fadeOut("slow");  // fadeout the preloader

    if (typeof (EventSource) !== "undefined") {

        eventStream = new EventSource("statsStream.php");
        eventStream.addEventListener("block-info", function(e) {
            // if (e.origin != 'https://stats.recordskeeper.co') {
            //     console.log('Origin was not https://stats.recordskeeper.co');
            //     return;
            // }
            var streamData = JSON.parse(e.data);
            $("#best_block").html("#"+streamData.best_block);
            $("#last_block_time").html(streamData.last_block_time);
            $("#xrk_supply").html(streamData.xrk_supply/100000000);
        }, false);

        eventStream.addEventListener("pending-tx", function(e) {
            processStream(e.data);         
        }, false);

        eventStream.addEventListener("average-block-time", function(e) {
            processStream(e.data);         
        }, false);

        eventStream.addEventListener("chart-data", function(e) {
            processStream(e.data);         
        }, false);

        eventStream.addEventListener("tx-count", function(e) {
            processStream(e.data);         
        }, false);

        eventStream.onmessage = function (e) {
            console.log("Generic message: " + e.data);
          };

        eventStream.onerror = function () {
            console.log("Error in update stream");
          };
          

    } 
    else {
        alert("Your browser does not support Event Streams!");
    }

    // timer for last block mined duration
    var lastBlockUpdateTimer = null; 

    $('#last_block_time').on('DOMSubtreeModified',function(){
        var lastBlockTime = parseInt(document.getElementById("last_block_time").textContent);
        if (lastBlockTime >= 0) {
            clearInterval(lastBlockUpdateTimer);
            var ts = Math.round((new Date()).getTime() / 1000);
            var timeDiff = ts - lastBlockTime;
            console.log(lastBlockTime);

            lastBlockUpdateTimer = setInterval(function() {
                document.getElementById("last_block_time_diff").innerHTML = timeDiff + " s ago";
                timeDiff++;
            }, 1000); 
        }
      });

});

function processStream(data){
    console.log(data);
    
}

function streamClose(){
    if(typeof(eventStream)=="object"){
        eventStream.close();
        eventStream = false;
        console.log("Stream Closed"); 
    }
}


function getBlockInfo(){      
    var body = {"network":localStorage.network};
    $.ajax({
        type: "POST",
        url: base_url+"/blockInfo/",
        crossDomain: true,
        data: JSON.stringify(body),
        dataType: 'json',
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
        type: "POST",
        url: base_url+"/pendingTx/",
        crossDomain: true,
        data: JSON.stringify(body),
        dataType: 'json',
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
    var body = {'network':localStorage.network};
    $.ajax({
        type: "POST",
        url: base_url+"/txCount/",
        crossDomain: true,
        data: JSON.stringify(body),
        dataType: 'json',
        success: function (data, textStatus, xhr) {
            console.log(data);
            jQuery.parseJSON(JSON.stringify(data));
            $("#tx_count").html("#"+data[0].data.results[0].tx);
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log('Error in Operation',xhr);
        }
    });
}

function getAverageTime(){
    var body = {'network':localStorage.network};
    $.ajax({
        type: "POST",
        url: base_url+"/avgTime/",
        crossDomain: true,
        data: JSON.stringify(body),
        dataType: 'json',
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
    var body = {'network':localStorage.network};
    $.ajax({
        type: "POST",
        url: base_url+"/chart/",
        crossDomain: true,
        data: JSON.stringify(body),
        dataType: 'json',
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


// cookie creation
function createCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function getCookieValue(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}

function switchNetwork(network) {
    if (network !== "test" && network !== "main") {
        console.log("Not a valid network");
        return;
    }

    var networkColor = network === "test" ? testNetColor : mainNetColor;
    var networkLabel = network === "test" ? "TestNet" : "MainNet";
    var cbChecked = network === "test" ? true : false;

    createCookie("rk-network",network,365);
    $("#togglecontlabel").html(networkLabel);
    document.getElementById("cb1").checked = cbChecked;
    document.getElementById("top").style.backgroundColor=networkColor;

    var elements = document.getElementsByClassName("fas")
    for (var i = 0; i < elements.length; i++) {
        elements[i].style.color=networkColor;
    }
}

function resetData() {
    $("#best_block").html("#0");
    $("#last_block_time").html(Math.round((new Date()).getTime() / 1000));
    $("#xrk_supply").html("0");

    $("#tx_count").html("0");
    $("#pending_tx_count").html("0");
    $("#avg_time").html("0 s");
}