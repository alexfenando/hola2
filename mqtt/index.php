<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<!-- https://api.cloudmqtt.com/sso/js/mqttws31.js --> 
	
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
	
	<figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
        
    </p>
		
		
</figure>
	
	
  <head>
	  
    <title>Mosquitto Websockets</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="mqttws31.js" type="text/javascript"></script>
    <script src="jquery.min.js" type="text/javascript"></script>
    <script src="config.js" type="text/javascript"></script>

    <script type="text/javascript">
		
		usuario = 'avanzadas';
      contrasena = 'avanzadas';

      function OnOff(dato){
        message = new Paho.MQTT.Message(dato);
        message.destinationName = 'casa/cocina/nevera'
        client.send(message);
      };
		
		
    var mqtt;
    var reconnectTimeout = 2000;
		
    function MQTTconnect() {
	if (typeof path == "undefined") {
		path = '/mqtt';
	}
	mqtt = new Paho.MQTT.Client(
			host,
			port,
			path,
			"web_" + parseInt(Math.random() * 100, 10)
	);
        var options = {
            timeout: 3,
            useSSL: useTLS,
            cleanSession: cleansession,
            onSuccess: onConnect,
            onFailure: function (message) {
                $('#status').val("Connection failed: " + message.errorMessage + "Retrying");
                setTimeout(MQTTconnect, reconnectTimeout);
            }
        };

        mqtt.onConnectionLost = onConnectionLost;
        mqtt.onMessageArrived = onMessageArrived;

        if (username != null) {
            options.userName = username;
            options.password = password;
        }
        console.log("Host="+ host + ", port=" + port + ", path=" + path + " TLS = " + useTLS + " username=" + username + " password=" + password);
        mqtt.connect(options);
    }

    function onConnect() {
        $('#status').val('Connected to ' + host + ':' + port + path);
        // Connection succeeded; subscribe to our topic
        mqtt.subscribe(topic, {qos: 0});
        $('#topic').val(topic);
    }

    function onConnectionLost(response) {
        setTimeout(MQTTconnect, reconnectTimeout);
        $('#status').val("connection lost: " + responseObject.errorMessage + ". Reconnecting");

    };

    function onMessageArrived(message) {

        var topic = message.destinationName;
        var payload = message.payloadString;

        $('#ws').prepend('<li>' + topic + ' = ' + payload + '</li>');
		
		temperaturas = parseFloat(message.payloadString);
		
		
		
		
		
    };
		  
		 var clientId = "ws" + Math.random();
        // Create a client instance
        var client = new Paho.MQTT.Client("34.123.90.178", 9000, clientId);
		
		
		
		
		Highcharts.chart('container', {
    chart: {
        type: 'spline',
        animation: Highcharts.svg, // don't animate in old IE
        marginRight: 10,
        events: {
            load: function () {

                // set up the updating of the chart each second
                var series = this.series[0];
                setInterval(function () {
                    var x = (new Date()).getTime(), // current time
                        y = temperaturas;
                    series.addPoint([x, y]);
                }, 1000);
            }
        }
    },

    time: {
        useUTC: false
    },

    title: {
        text: 'Temperatura'
    },

    accessibility: {
        announceNewData: {
            enabled: true,
            minAnnounceInterval: 15000,
            announcementFormatter: function (allSeries, newSeries, newPoint) {
                if (newPoint) {
                    return 'New point added. Value: ' + newPoint.y;
                }
                return false;
            }
        }
    },

    xAxis: {
        type: 'datetime',
        tickPixelInterval: 150
    },

    yAxis: {
        title: {
            text: 'Value'
        },
        plotLines: [{
            value: 0,
            width: 100,
            color: 'white'
        }]
    },

    tooltip: {
        headerFormat: '<b>{series.name}</b><br/>',
        pointFormat: '{point.x:%Y-%m-%d %H:%M:%S}<br/>{point.y:.2f}'
    },

    legend: {
        enabled: false
    },

    exporting: {
        enabled: false
    },

    series: [{
        name: 'Tem',
        data: (function () {
            // generate an array of random data
            var data = [],
                time = (new Date()).getTime(),
                i;

            for (i = -19; i <= 0; i += 1) {
                data.push({
                    x: time + i * 100,
                    y: 0
                });
            }
            return data;
        }())
    }]
});

    $(document).ready(function() {
        MQTTconnect();
    });

    </script>
  </head>
  <body >
	  
	  	  
	  
	  <a href="#" onClick="sumar()">encendido</a>
	  < script scrc="js/envioo.js"></script>
	  
	  <div>
		  <form action="" method="post" >
		  
        <a>Encender Led: </a>
        <button type='button' onclick='OnOff("ON")'>ON</button>
        <button type='button' onclick='OnOff("OFF")'>OFF</button>
	
  
	  </div>

		  
		
    <h1>Mosquitto Websockets</h1>
	  
    <div>
        <div>Subscribed to <input type='text' id='topic' disabled />
        Status: <input type='text' id='status' size="80" disabled /></div>

        <ul id='ws' style="font-family: 'Courier New', Courier, monospace;"></ul>
    </div>
	  
  </body>
</html>
