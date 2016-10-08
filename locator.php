<?php
$idpass="";
if ($_GET["id"]){
$idpass=$_GET["id"];
}
$lng=$_GET["lon"];
$lat=$_GET["lat"];
?>
<!DOCTYPE html>
<html lang="it">
	<head>
		<meta charset="utf-8">
		<title>Isocrone</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta property="og:image" content="http://www.piersoft.it/isocrone/logopin.png"/>
      <!-- Leaflet 0.5: https://github.com/CloudMade/Leaflet-->
		<link rel="stylesheet" href="http://joker-x.github.io/Leaflet.geoCSV/lib/leaflet.css" />
		<!--[if lte IE 8]> <link rel="stylesheet" href="http://joker-x.github.io/Leaflet.geoCSV/lib/leaflet.ie.css" />  <![endif]-->
		<script src="http://joker-x.github.io/Leaflet.geoCSV/lib/leaflet.js"></script>

		<script src="leaflet-hash.js"></script>
		<!-- jQuery 1.8.3: http://jquery.com/ -->
		<script src="http://joker-x.github.io/Leaflet.geoCSV/lib/jquery.js"></script>

		<style>
		html, body, #mapa {
			margin: 0;
			padding: 0;
			width: 100%;
			height: 100%;
			font-family: Arial, sans-serif;
			font-color: #38383;
		}

    .search-input {
    	font-family:Courier
    }
    .search-input,
    .leaflet-control-search {
    	max-width:400px;
    }
		#logo{
		position:fixed;
		top:10px;
		left:50px;
		}
		#botonera {
			position:fixed;
			top:10px;
			left:50px;
			z-index: 2;
		}

		#cargando {
			position:fixed;
			top:0;
			left:0;
			width:100%;
			height:100%;
			background-color:#666;
			color:#fff;
			font-size:2em;
			padding:20% 40%;
			z-index:10;
		}

		.boton {
			border: 1px solid #96d1f8;
			background: #65a9d7;
			background: -webkit-gradient(linear, left top, left bottom, from(#3e779d), to(#65a9d7));
			background: -webkit-linear-gradient(top, #3e779d, #65a9d7);
			background: -moz-linear-gradient(top, #3e779d, #65a9d7);
			background: -ms-linear-gradient(top, #3e779d, #65a9d7);
			background: -o-linear-gradient(top, #3e779d, #65a9d7);
			padding: 12px 24px;
			-webkit-border-radius: 10px;
			-moz-border-radius: 10px;
			border-radius: 10px;
			-webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
			-moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
			box-shadow: rgba(0,0,0,1) 0 1px 0;
			text-shadow: rgba(0,0,0,.4) 0 1px 0;
			color: white;
			font-size: 17px;
			/*font-family: Helvetica, Arial, Sans-Serif;*/
			text-decoration: none;
			vertical-align: middle;
		}
		.boton:hover {
			border-top-color: #28597a;
			background: #28597a;
			color: #ccc;
		}
		.boton:active {
			border-top-color: #1b435e;
			background: #1b435e;
		}
#infodiv{
       position:fixed;
        right:2px;
        bottom:20px;
	font-size: 12px;
        z-index:9999;
        border-radius: 10px;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        border: 2px solid #808080;
        background-color:#fff;
        padding:5px;
        box-shadow: 0 3px 14px rgba(0,0,0,0.4)
}
		</style>
	</head>
	<body>
		<div id="mapa"></div>
		<div id="cargando">Loading data...</div>

<div id="infodiv" style="leaflet-popup-content-wrapper">
<b>Mappa derivata dal progetto <a href="http://isocrone.labmod.org/#6/41.951/12.557">Isocrone Italia</a>. adattamento GPS by @piersoft</b>
</div>
<div id="logo" style="leaflet-popup-content-wrapper">
<img src="legend.png" width="120px" title="legenda" alt="legenda">
</div>
<script>
var lat="<?php echo $lat; ?>";
var lng="<?php echo $lng; ?>";

var dataLayer = new L.geoJson();
var idpass="<?php echo $idpass ?>";

var mapa = L.map('mapa', {attributionControl:true}).setView([lat,lng],14);
var markeryou = L.marker([lat, lng],{
		 draggable: false
 }).addTo(mapa);
 markeryou.bindPopup("<b>Sei qui</b>");
var maposmUrl = 'http://tile.openstreetmap.org/{z}/{x}/{y}.png';
var maposmUrl = 'https://tiles.wmflabs.org/bw-mapnik/{z}/{x}/{y}.png'
maposmAttrib = 'Data, and map information provided by <a href="http://www.openstreetmap.org/" target="_blank">OpenStreetMap</a> and contributors.';
var mapboxUrl = 'http://c.tiles.mapbox.com/v3/tmcw.map-7s15q36b/{z}/{x}/{y}.png';
mapboxAttrib = 'Data, imagery and map information provided by <a href="http://mapbox.com" target="_blank">Mapbox</a>,<a href="http://www.openstreetmap.org/" target="_blank">OpenStreetMap</a> and contributors.';
var maposm = new L.TileLayer(maposmUrl, {attribution: maposmAttrib}).addTo(mapa);
var mapbox = new L.TileLayer(mapboxUrl, {attribution: mapboxAttrib});

 var layerControl = new L.Control.Layers({
 		'Osm': maposm,
 		'Mapbox': mapbox

 	});

 layerControl.addTo(mapa);
 dataLayer.addTo(mapa);

var hash = new L.Hash(mapa);

function onEachFeature(feature, layer) {
    // does this feature have a property named popupContent?


		console.log(feature.properties.time);
			if(feature.properties.time == '10') {
				layer.setStyle({fillOpacity: 0.7});
			}
			if(feature.properties.time == '20') {
				layer.setStyle({fillOpacity: 0.4});
			}
			if(feature.properties.time == '30') {
					layer.setStyle({fillOpacity: 0.1});

			}
};

function addDataToMapUCL(data, mapa) {

  var dataLayer1 = L.geoJson(data,{
        onEachFeature: onEachFeature
        });
    	dataLayer1.addTo(dataLayer);
			  $('#cargando').delay(500).fadeOut('slow');
}
var url="request.php?lng="+lng+"&lat="+lat;

//var url="http://isocrone.labmod.org/foot/?lng="+lng+"&lat="+lat+"&intervals[]=10&intervals[]=20&intervals[]=30";
$.getJSON(url, function(data) { addDataToMapUCL(data, mapa); });
//console.log($.getJSON(url, function(data) { addDataToMapUCL(data, mapa); }));
//console.log(url);
</script>

	</body>
</html>
