<?php $this->set( 'title_for_layout', "Agregar nuevo grupo" ); ?>
<div id="acciones">
	<?php echo $this->Html->link( 'Lista de Grupos', array('action' => 'index'));?>
</div>
<br />
<?php echo $this->Form->create('Grupo');?>
<fieldset>
	<legend><h2>Agregar nuevo grupo</h2></legend>
<?php
	echo $this->Form->input('nombre', array( 'type' => 'text' ) );
	echo $this->Form->end( 'Agregar' );
?>
</fieldset>