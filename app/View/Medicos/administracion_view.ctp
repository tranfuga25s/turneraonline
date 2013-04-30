<?php $this->set( 'title_for_layout', "Datos del medico" ); ?>
<div id="acciones">
	<?php echo $this->Html->link( 'Editar Medico', array( 'action' => 'edit', $medico['Medico']['id_medico'] ) ); ?>&nbsp;
	<?php echo $this->Form->postLink( 'Eliminar medico', array( 'action' => 'delete', $medico['Medico']['id_medico']), null, __('Are you sure you want to delete # %s?', $medico['Medico']['id_medico'] ) ); ?> &nbsp;
	<?php echo $this->Html->link( 'Lista de Medicos', array( 'action' => 'index' ) ); ?>&nbsp;
	<?php echo $this->Html->link( 'Nuevo Medico', array( 'action' => 'add' ) ); ?>
</div>
<br />	
<h2>Datos del medico</h2>
<dl>
	<dt>Email</dt>
	<dd>
		<?php echo $this->Html->link( h($medico['Usuario']['email']), $medico['Usuario']['email'] ); ?>
		&nbsp;
	</dd>
	<dt>Nombre</dt>
	<dd>
		<?php echo h($medico['Usuario']['nombre']); ?>
		&nbsp;
	</dd>
	<dt>Apellido</dt>
	<dd>
		<?php echo h($medico['Usuario']['apellido']); ?>
		&nbsp;
	</dd>
	<dt>Tel&eacute;fono</dt>
	<dd>
		<?php echo h($medico['Usuario']['telefono']); ?>
		&nbsp;
	</dd>
	<dt>Tel&eacute;fono Celular</dt>
	<dd>
		<?php echo h($medico['Usuario']['celular']); ?>
		&nbsp;
	</dd>
	<dt>Notificaci&oacute;nes</dt>
	<dd>
		<?php if( $medico['Usuario']['notificaciones'] ) {
			echo "Si";
		      } else {
			echo "No";
		      } ?>
		&nbsp;
	</dd>
	<dt>Especialidad</dt>
	<dd>
		<?php echo $this->Html->link( $medico['Especialidad']['nombre'], array('controller' => 'especialidades', 'action' => 'view', $medico['Especialidad']['id_especialidad'])); ?>
		&nbsp;
	</dd>
	<dt>Clinica</dt>
	<dd>
		<?php echo $this->Html->link($medico['Clinica']['nombre'], array('controller' => 'clinicas', 'action' => 'view', $medico['Clinica']['id_clinica'])); ?>
		&nbsp;
	</dd>
</dl>
