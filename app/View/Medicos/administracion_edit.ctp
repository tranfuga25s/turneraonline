<?php $this->set( 'title_for_layout', "Editar un médico" ); ?>
<div id="acciones">
	<?php echo $this->Html->link( 'Lista de Médicos', array('action' => 'index'));
		  echo $this->Html->link( 'Modificar datos de usuario', array( 'controller' => 'usuarios', 'action' => 'edit', $this->request->data['Medico']['usuario_id'] ) );
		  echo $this->Html->link( 'Modificar Disponibilidad', array( 'action' => 'disponibilidad' ) );
		  echo $this->Html->link( 'Dar de baja como médico', array( 'action' => 'darBaja', $this->request->data['Medico']['id_medico'] ) ); ?>
</div>
<br />
<?php echo $this->Form->create('Medico');?>
<fieldset>
	<legend><h2>Editar los datos de un m&eacute;dico</h2></legend>
<?php
	echo $this->Form->input( 'id_medico' );
	echo $this->Form->input( 'clinica_id' );
	echo $this->Form->input( 'especialidad_id', array( 'options' => $especialidades ) );
	echo $this->Form->input( 'visible', array( 'label' => 'Visible para los pacientes' )  );
?>
<?php echo $this->Form->end( 'Guardar cambios' );?>
</fieldset>