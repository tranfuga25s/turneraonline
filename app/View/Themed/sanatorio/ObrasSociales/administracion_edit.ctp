<?php $this->set( 'title_for_layot', "Modificar datos de obra social" ); ?>
<div id="acciones">
		<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ObraSocial.id_obra_social')), null, __('Are you sure you want to delete # %s?', $this->Form->value('ObraSocial.id_obra_social'))); ?>
		<?php echo $this->Html->link(__('List Obras Sociales'), array('action' => 'index'));?>	
</div>
<br />
<?php echo $this->Form->create('ObraSocial');?>
<fieldset>
	<legend><h2>Editar obra social</h2></legend>
<?php
	echo $this->Form->input('id_obra_social');
	echo $this->Form->input('nombre');
	echo $this->Form->input('direccion');
	echo $this->Form->input('telefono');
?>
</fieldset>
<?php echo $this->Form->end( 'Guardar cambios'); ?>
