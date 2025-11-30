$(document).ready(function(){
	$("#idsearch").keyup(function(e){
		if(e.keyCode==13){
			buscar_productos();

		}
		
		
	});
});


function buscar_productos(){
	window.location.href="busqueda.php?