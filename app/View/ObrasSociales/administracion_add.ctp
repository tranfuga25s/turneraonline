<?php $this->set( 'title_for_layout', "Agregar nueva obra social" ); ?>
<div id="acciones">
	<?php echo $this->Html->link( 'Lista de Obras Sociales', array('action' => 'index'));?>
</div>
<br />
<?php echo $this->Form->create('ObraSocial');?>
<fieldset>
	<legend><h2>Agregar nueva obra social</h2></legend>
<?php
	echo $this->Form->input('nombre');
	echo $this->Form->input('direccion');
	echo $this->Form->input('telefono');
?>
</fieldset>
<?php echo $this->Form->end( 'Agregar');?>

