<div class="turnos index">
	<h2><?php echo __('Turnos');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('paciente_id');?></th>
			<th><?php echo $this->Paginator->sort('medico_id');?></th>
			<th><?php echo $this->Paginator->sort('fecha_inicio');?></th>
			<th><?php echo $this->Paginator->sort('fecha_fin');?></th>
			<th><?php echo $this->Paginator->sort('consultorio_id');?></th>
			<th><?php echo $this->Paginator->sort('recibido');?></th>
			<th><?php echo $this->Paginator->sort('atendido');?></th>
			<th><?php echo $this->Paginator->sort('cancelado');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($turnos as $turno): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($turno['Paciente']['apellido'], array('controller' => 'usuarios', 'action' => 'view', $turno['Paciente']['id_usuario'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($turno['Medico']['apellido'], array('controller' => 'usuarios', 'action' => 'view', $turno['Medico']['id_usuario'])); ?>
		</td>
		<td><?php echo h($turno['Turno']['fecha_inicio']); ?>&nbsp;</td>
		<td><?php echo h($turno['Turno']['fecha_fin']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($turno['Consultorio']['nombre'], array('controller' => 'consultorios', 'action' => 'view', $turno['Consultorio']['id_consultorio'])); ?>
		</td>
		<td><?php echo h($turno['Turno']['recibido']); ?>&nbsp;</td>
		<td><?php echo h($turno['Turno']['atendido']); ?>&nbsp;</td>
		<td><?php echo h($turno['Turno']['cancelado']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $turno['Turno']['id_turno'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $turno['Turno']['id_turno'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $turno['Turno']['id_turno']), null, __('Are you sure you want to delete # %s?', $turno['Turno']['id_turno'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Turno'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Paciente'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Consultorios'), array('controller' => 'consultorios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Consultorio'), array('controller' => 'consultorios', 'action' => 'add')); ?> </li>
	</ul>
</div>
