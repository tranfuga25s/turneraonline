<div class="turnos form">
<?php echo $this->Form->create('Turno');?>
	<fieldset>
		<legend><?php echo __('Administracion Add Turno'); ?></legend>
	<?php
		echo $this->Form->input('paciente_id');
		echo $this->Form->input('medico_id');
		echo $this->Form->input('fecha_inicio');
		echo $this->Form->input('fecha_fin');
		echo $this->Form->input('consultorio_id');
		echo $this->Form->input('recibido');
		echo $this->Form->input('atendido');
		echo $this->Form->input('cancelado');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link( 'Lista de Turnos', array('action' => 'index') );?></li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Paciente'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Consultorios'), array('controller' => 'consultorios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Consultorio'), array('controller' => 'consultorios', 'action' => 'add')); ?> </li>
	</ul>
</div>
