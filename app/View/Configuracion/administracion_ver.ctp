<?php $this->set( 'title_for_layout', "Configuracion del sistema" ); ?>
<fieldset>
	<legend><h2>Configuración general del sistema</h2></legend>
	<?php echo $this->Form->create( false, array( 'action' => 'guardar', 'id' => 'fconfig' ) ); ?>
	<fieldset>
		<legend><h3>Turnos</h3></legend>
		<b>Cantidad maxima de dias con la que se puede reservar un turno</b>:
		<?php echo $this->Form->input( 'dias', array( 'value' => $datos['dias_turnos'], 'label' => false, 'div' => false, 'size' => 2 ) ); ?> dias.
	</fieldset>
	<fieldset>
		<legend><h3>Notificaciones</h3></legend>
		<b>Cantidad de horas antes del turno que se avisará al paciente por email:</b>
		<?php echo $this->Form->input( 'horas', array( 'label' => false, 'after' => 'hora(s).', 'value' => $datos['notificaciones']['horas_proximo'], 'div' => false, 'size' => 2 ) ); ?>
		<br />
		<b>Cuenta de email con el cual se recibirá como remitente las notificaciones enviadas:</b>
		<?php echo $this->Form->input( 'email', array( 'label' => false, 'value' => $datos['email'], 'div' => false, 'size' => 26 ) ); ?>

        <b>Cantidad de minutos antes que se recibirá el aviso de turno mediante sms:</b>
        <?php echo $this->Form->input( 'minutos', array( 'label' => false, 'value' => $datos['notificaciones']['minutos_proximo_sms'], 'div' => false, 'size' => 26 ) ); ?>
	</fieldset>
	<?php echo $this->Form->submit( 'Guardar' ); ?>
</fieldset>