<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
    <title>geoloc</title>
 
	<script type="text/javascript" src="JS/jquery-2.2.1.js"></script>
	
	<script type="text/javascript">
	var inicio=0;
	var timeout=0;
	var vLat, vLon;
 
	function empezarDetener(elemento)
	{
		if(timeout==0)
		{
			// empezar el cronometro
 
			elemento.value="Detener";
 
			// Obtenemos el valor actual
			inicio=vuelta=new Date().getTime();
 
			// iniciamos el proceso
			funcionando();
			
		}else{
			// detemer el cronometro
 
			elemento.value="Empezar";
			clearTimeout(timeout);
			timeout=0;
		}
	}
 
	function funcionando()
	{
		// obteneos la fecha actual
		var actual = new Date().getTime();
 
		// obtenemos la diferencia entre la fecha actual y la de inicio
		var diff=new Date(actual-inicio);
 
		// mostramos la diferencia entre la fecha actual y la inicial
		var result=LeadingZero(diff.getUTCHours())+":"+LeadingZero(diff.getUTCMinutes())+":"+LeadingZero(diff.getUTCSeconds());
		document.getElementById('crono').innerHTML = result;
		obtener_localizacion();
 
		// Indicamos que se ejecute esta función nuevamente dentro de 1 segundo
		timeout=setTimeout("funcionando()",98);
	}
 
	/* Funcion que pone un 0 delante de un valor si es necesario */
	function LeadingZero(Time) {
		return (Time < 10) ? "0" + Time : + Time;
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function obtener_localizacion() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(coordenadas);
		}else{
		alert('Tu navegador no soporta la API de geolocalizacion');
		}
	}
	
	var latitud;
	var longitud;
	
	function coordenadas(position) {
		latitud = position.coords.latitude;
		longitud = position.coords.longitude;
		
		var mapa = document.getElementById("mapa");
		mapaCad = "http://maps.google.com/maps/api/staticmap?center=" + latitud + "," + longitud + "&zoom=15&size=400x400&markers=color:green|label:A|" + latitud + "," + longitud + "&sensor=false";
		
		mapa.src = mapaCad;
		
		document.getElementById("latitud").value=latitud;
		document.getElementById("longitud").value=longitud;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	var times=0;
	var c=0;
	
$(document).ready(function(){
	$('#empezar').click( function repeat() {
		
		 $.getJSON("guardar.json", function(data){
			 console.log(data);
			 
			 
			 vLat=parseFloat(data.Jlati);
			 vLon=parseFloat(data.Jlongi);
			 
			 $('#a1').val(''+vLat);
			 $("#a2").val(''+vLon);
			});
		
		times=setTimeout(repeat, 300);
		c++;
		});
});

	</script>
 
	<style>
	.crono_wrapper {text-align:center;width:200px;}
	</style>
</head>
 
<body>

<form id="latlong">
	latitud:<input type="text" id="latitud" value="">
	longitud:<input type="text" id="longitud" value="">
</form>

<form id="jqtest">
	gagag<input type="text" id="a1" value="">
	bloblob<input type="text" id="a2" value="">
</form>
 
<div class="crono_wrapper">
	<h2 id='crono'>00:00:00</h2>
	<input type="button" id="empezar" value="Empezar" onclick="empezarDetener(this);">
</div>
 
 <p><img id="mapa" src=""></p>

 
</body>
</html>