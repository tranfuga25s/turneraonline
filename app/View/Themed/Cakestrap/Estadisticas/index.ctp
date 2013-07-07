<?php
$this->set( 'title_for_layout', "Estadisticas" );
echo $this->Html->script( 'https://www.google.com/jsapi', array( 'inline' => false ) );
?>
<script>

	function actualizarGraficos() {
		// Genero las llamadas en ajax para cada grafico
		var acciones = <?php echo json_encode( $acciones ); ?>;
		$(".contenedor-graficos").empty();
		$(acciones).each( function ( indice, objeto ) {
			var d=document.createElement('div');
			//var h=document.createElement('h4');
			var d2=document.createElement('div');
			$(d).addClass('span4').addClass('well-small').addClass( 'text-center' ).appendTo($(".contenedor-graficos"));
			//$(h).html( objeto.titulo ).appendTo($(d));
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
				$( "#"+accion ).html( datos );
			},
			error: function( jqXHR, textStatus, errorThrown ) {
				$("#"+accion).append( textStatus );
			},
			beforeSend: function() {
				$("#"+accion).html( "<i class='icon-time'></i>Cargando..." );
			}
		});
	}

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1.0', {'packages':['corechart']});
    // Set a callback to run when the Google Visualization API is loaded.
    //google.setOnLoadCallback(drawChart);
    var charts = new Array();

</script>
<div class="row-fluid">
    <div class="span12 well">
        <h3>Estadisticas del sistema</h3>
        <p>A continuaci&oacute;n verá los graficos de uso y estado del sistema.</p>
        <div class="btn-group">
            <?php echo $this->Html->link( 'Volver', '/', array( 'class' => 'btn btn-primary' ) ); ?>
            <?php echo $this->Html->tag( 'a', 'Actualizar graficos', array( 'onclick' => 'actualizarGraficos()', 'class' => 'btn btn-success' ) ); ?>
        </div>
    </div>
</div>
<div class="contenedor-graficos row-fluid">
</div>
<div><small>Basado en la api de <a href="https://developers.google.com/chart/">Google Chart</a></small></div>
<script type="text/javascript">$( function() { actualizarGraficos(); });</script>