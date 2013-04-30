<?php $this->set( 'title_for_layout', "Editar consultorio" ); ?>
<div id="acciones">
	<?php echo $this->Form->postLink( 'Eliminar', array('action' => 'delete', $this->Form->value('Consultorio.id_consultorio')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Consultorio.id_consultorio'))); ?> &nbsp;
	<?php echo $this->Html->link( 'Lista de Consultorios', array('action' => 'index'));?> &nbsp;
	<?php echo $this->Html->link( 'Lista de Clinicas', array('controller' => 'clinicas', 'action' => 'index')); ?> &nbsp;
</div>
<br />
	
<?php echo $this->Form->create('Consultorio');?>
<fieldset>
		<legend><h2>Editar un consultorio</h2></legend>
	<?php
		echo $this->Form->input('id_consultorio');
		echo $this->Form->input('clinica_id', array( 'label' => 'Clinica perteneciente:' ) );
		echo $this->Form->input('nombre', array( 'type' => 'text', 'label' => 'Nombre descriptivo:'));
	?>
	<?php echo $this->Form->end( 'Guardar cambios' );?>
</fieldset>


