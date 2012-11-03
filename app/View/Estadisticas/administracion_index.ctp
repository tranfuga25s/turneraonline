<?php
$this->set( 'title_for_layout', "Estadisticas" );
echo $this->Html->script( 'https://www.google.com/jsapi', array( 'inline' => false ) ); 
?>
<script>
	//$( function() { actualizarGraficos(); });
	
	function actualizarGraficos() {
		// Genero las llamadas en ajax para cada grafico
		var acciones = <?php echo json_encode( $acciones ); ?>;
		$(".contenedor-graficos").empty();
		$(acciones).each( function ( indice, objeto ) {
			var d=document.createElement('div');
			var h=document.createElement('h3');
			var d2=document.createElement('div');
			$(d).addClass('contenedor-grafico').appendTo($(".contenedor-graficos"));
			$(h).html( objeto.titulo ).appendTo($(d));
			$(d2).attr( 'id', objeto.accion ).appendTo( $(d) );
			pedirGrafico( objeto.accion );			
		});
	}
		
	function pedirGrafico( accion ) {
		$.ajax({
			url: '<?php echo Router::url( '/' ); ?>administracion/estadisticas/'+accion,
			cache: false,
			dataType: 'html',
			success: function( datos ) {
				$( "#"+accion).html( datos );
			},
			error: function( jqXHR, textStatus, errorThrown ) {
				$("#"+accion).append( textStatus );
			},
			beforeSend: function() {
				$("#"+accion).html( "Cargando..." );
			}	 
		});
	}
	
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1.0', {'packages':['corechart']});
    // Set a callback to run when the Google Visualization API is loaded.
    //google.setOnLoadCallback(drawChart);
    var charts = new Array();

</script>
<style>
.contenedor-grafico {
	float: left;
	width: 400px;
	height: 290px;
	border: solid 1px #C4C5C2;
	overflow: hidden;
	margin: 2px 2px 2px 2px;
	background-color: #C4C5C2;
}
.contenedor-grafico h3 {
	text-align: center;
	font-weight: bolder;
}
.contenedor-graficos {
	clear: both;
}
</style>
<h2>Estadisticas del sistema</h2>
<p>A continuaci&oacute;n verá los graficos de uso y estado del sistema.</p>
<div id="acciones">
	<?php echo $this->Html->tag( 'a', 'Actualizar graficos', array( 'onclick' => 'actualizarGraficos()', 'class' => 'acciones' ) ); ?>
</div>
<div class="contenedor-graficos"></div><br />
