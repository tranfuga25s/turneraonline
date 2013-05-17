<?php $this->set( 'title_for_layout', "Resumen diario" ); ?>
<div class="row-fluid">
	<div class="span8 well">
		<h3>Resumen diario de turnos</h3>
		<p>Usted puede recibir todos los días en su correo los turnos resevados hasta las 24 horas del día anterior en un listado simple para tener de referencia.</p>
		<br />
		<p><b> El estado actual es: </b> &nbsp;
		<?php if( $resumen ) {
			echo $this->Html->tag( 'button', 'Activado', array( 'class' => "btn btn-large btn-primary disabled", "disabled" => true ) );
		} else {
			echo $this->Html->tag( 'button', 'Desactivado', array( 'class' => "btn btn-large btn-warning disabled", "disabled" => true ) );
		} ?></p>
	</div>
	<div class="span4 well">
		<?php echo $this->Form->create( 'Secretaria', array( 'action' => 'resumen' ) ); ?>
		<fieldset>
			<legend>Cambiar Preferencia</legend>
			<?php echo $this->Form->input( 'resumen', array( 'label' => 'Resumen Habilitado', 'value' => $resumen ) ); ?>
	   	</fieldset>
		<?php echo $this->Form->end( array( 'label' => 'Cambiar', 'class' => 'btn btn-success', 'div' => array( 'class' => 'form-actions' ) ) ); ?>
	</div>
</div>