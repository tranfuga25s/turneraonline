<div id="acciones">
	<?php echo $this->Html->link( 'Lista de Consultorios', array('action' => 'index'));?>&nbsp;
	<?php echo $this->Html->link( 'Lista de Clinicas', array('controller' => 'clinicas', 'action' => 'index')); ?>
</div>
<br />
<?php echo $this->Form->create('Consultorio');?>
	<fieldset>
		<legend><h2>Agregar nuevo consultorio</h2></legend>		
	<?php
		echo $this->Form->input('clinica_id', array( 'label' => 'Clinica de pertenencia:' ) );
		echo $this->Form->input('nombre', array( 'type' => 'text', 'label' => 'Nombre identificatorio:' ) );
	?>
	<?php echo $this->Form->end( 'Agregar');?>
</fieldset>

