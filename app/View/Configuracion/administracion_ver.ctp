<?php $this->set( 'title_for_layout', "Configuracion de la turnera" ); ?>
<div class="decorado1">
	<div class="titulo1">Configuración general del sistema</div>
	<?php echo $this->Form->create( false, array( 'action' => 'guardar', 'id' => 'fconfig' ) ); ?>
	<div class="titulo2">Turnos</div>
		<br />
		<b>Cantidad maxima de dias con la que se puede reservar un turno</b>:
		<?php echo $this->Form->input( 'dias', array( 'value' => $datos['dias_turnos'], 'label' => false, 'div' => false ) ); ?> dias.
		<br />
		<br />
	<div class="titulo2">Notificaciones</div>
		<b>Cantidad de horas antes del turno que se avisará al paciente:</b>
		<?php echo $this->Form->input( 'horas', array( 'label' => false, 'after' => 'hora(s).', 'value' => $datos['notificaciones']['horas_proximo'], 'div' => false ) ); ?>
		<br />
		<b>Cuenta de email con el cual se recibirá como remitente las notificaciones enviadas:</b>
		<?php echo $this->Form->input( 'email', array( 'label' => false, 'value' => $datos['email'], 'div' => false ) ); ?>
		<span style="text-align: right;">
			<?php echo $this->Form->submit( 'Guardar' ); ?>
		</span>
</div>