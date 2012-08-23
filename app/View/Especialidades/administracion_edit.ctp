<div class="especialidades form">
<?php echo $this->Form->create('Especialidad');?>
	<fieldset>
		<legend><?php echo __('Administracion Edit Especialidade'); ?></legend>
	<?php
		echo $this->Form->input('id_especialidad');
		echo $this->Form->input('nombre');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Especialidade.id_especialidad')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Especialidade.id_especialidad'))); ?></li>
		<li><?php echo $this->Html->link(__('List Especialidades'), array('action' => 'index'));?></li>
	</ul>
</div>
