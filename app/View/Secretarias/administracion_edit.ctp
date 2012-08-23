<div class="secretarias form">
<?php echo $this->Form->create('Secretaria');?>
	<fieldset>
		<legend><?php echo __('Administracion Edit Secretaria'); ?></legend>
	<?php
		echo $this->Form->input('id_secretaria');
		echo $this->Form->input('usuario_id');
		echo $this->Form->input('clinica_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Secretaria.id_secretaria')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Secretaria.id_secretaria'))); ?></li>
		<li><?php echo $this->Html->link(__('List Secretarias'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clinicas'), array('controller' => 'clinicas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Clinica'), array('controller' => 'clinicas', 'action' => 'add')); ?> </li>
	</ul>
</div>
