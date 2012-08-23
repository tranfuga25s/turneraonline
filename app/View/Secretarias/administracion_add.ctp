<div class="secretarias form">
<?php echo $this->Form->create('Secretaria');?>
	<fieldset>
		<legend>Agregar una nueva secretaria</legend>
<b>Aclaracion importante:</b> Para que el usuario pueda aparecer en la lista desplegable debe estar registrado con el grupo de secretarias.
	<?php
		echo $this->Form->input('usuario_id');
		echo $this->Form->input('clinica_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3>Acciones</h3>
	<ul>
		<li><?php echo $this->Html->link( 'Lista de Secretarias', array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link( 'Lista de Usuarios', array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link( 'Lista de Clinicas', array('controller' => 'clinicas', 'action' => 'index')); ?> </li>
	</ul>
</div>
