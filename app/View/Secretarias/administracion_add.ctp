<div class="secretarias form">
<?php echo $this->Form->create('Secretaria');?>
	<fieldset>
		<legend><?php echo __('Administracion Add Secretaria'); ?></legend>
	<?php
		echo $this->Form->input('usuario_id');
		echo $this->Form->input('clinica_id');
		echo $this->Form->input('resumen');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Secretarias'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clinicas'), array('controller' => 'clinicas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Clinica'), array('controller' => 'clinicas', 'action' => 'add')); ?> </li>
	</ul>
</div>
