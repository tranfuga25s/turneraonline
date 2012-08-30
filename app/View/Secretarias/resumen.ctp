<?php $this->set( 'title_for_layout', "Resumen diario" ); ?>
<script>
	$( function() {
		$( "span" ).button();
	})
</script>
<div class="decorado1">
	<div class="titulo1">Resumen diario de turnos</div>
	<p>Usted puede recibir todos los días en su correo los turnos resevados hasta las 24 horas del día anterior en un listado simple para tener de referencia.</p>
	<p> El estado actual es:</p> &nbsp;
	<?php if( $resumen ) {
		echo '<span style="color: green; font-weight: bolder; font-size: 145%;">Activado</span><br />';
	} else {
		echo '<span style="color: orange; font-weigth: bolder; font-size: 145%;">Desactivado</span><br />';
	} ?>
	<br />
	<div class="titulo2">Cambiar Preferencia</div>
	<?php echo $this->Form->create( 'Secretaria', array( 'action' => 'resumen' ) ); ?>
	<fieldset>
	<?php echo $this->Form->input( 'resumen', array( 'label' => 'Resumen Habilitado', 'value' => $resumen ) );
		  echo $this->Form->submit( 'Cambiar' );
    ?>
    </fieldset>
</div>
