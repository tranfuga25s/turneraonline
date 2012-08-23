<div class="consultorios form">
<?php echo $this->Form->create('Consultorio');?>
	<fieldset>
		<legend><?php echo __('Administracion Edit Consultorio'); ?></legend>
	<?php
		echo $this->Form->input('id_consultorio');
		echo $this->Form->input('clinica_id');
		echo $this->Form->input('nombre');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Consultorio.id_consultorio')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Consultorio.id_consultorio'))); ?></li>
		<li><?php echo $this->Html->link(__('List Consultorios'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Clinicas'), array('controller' => 'clinicas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Clinica'), array('controller' => 'clinicas', 'action' => 'add')); ?> </li>
	</ul>
</div>
