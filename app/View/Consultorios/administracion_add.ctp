<div class="consultorios form">
<?php echo $this->Form->create('Consultorio');?>
	<fieldset>
		<legend><?php echo __('Administracion Add Consultorio'); ?></legend>
	<?php
		echo $this->Form->input('clinica_id');
		echo $this->Form->input('nombre');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Consultorios'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Clinicas'), array('controller' => 'clinicas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Clinica'), array('controller' => 'clinicas', 'action' => 'add')); ?> </li>
	</ul>
</div>
