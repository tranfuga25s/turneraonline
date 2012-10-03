<?php
$this->set( 'title_for_layout', "Estadisticas" );
?>
<script>
	$( function() { actualizarGraficos(); });

	function actualizarGraficos() {
		// Genero las llamadas en ajax para cada grafico
		var acciones = <?php echo json_encode( $acciones ); ?>;
		$("#contenedor-graficos").empty();
		$(acciones).each( function ( indice, titulo ) {
			$("div").addClass("contenedor-grafico").append( $("h3").html( titulo ) ).append( $("div").attr( 'id', indice ) ).appendTo( $("#contenedor-graficos" ) ); 
			pedirGrafico( indice );
		});
	}
		
	function pedirGrafico( accion ) {
		$.ajax({
			url: '<?php echo Router::url( array( 'controller' => 'estadisticas', 'action' => '' ) ); ?>'+accion,
			cache: true,
			DataType: 'html',
			success: function( datos ) {
				$("#"+accion).html( datos );
			},
			error: function( jqXHR, textStatus, errorThrown ) {
				$("#"+accion).html( textStatus );
			},
			beforeSend: function() {
				$("#"+accion).html( "Cargando..." );
			}	 
		});
	}
</script>
<h2>Estadisticas del sistema</h2>
<p>A continuaci&oacute;n verá los graficos de uso y estado del sistema.</p>
<div class="contenedor-graficos"></div>
<?php echo $this->Html->tag( 'a', 'Actualizar graficos', array( 'onclick' => 'actualizarGraficos()' ) ); ?>
