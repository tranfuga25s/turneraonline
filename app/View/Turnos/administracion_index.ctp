<?php $this->set( 'title_for_layout', "Listado de turnos" ); ?>
<script>
 $( function() { $("a", "#accion").button(); });
</script>
<div id="accion">
<?php echo $this->Html->link( 'Nuevo Turno', array('action' => 'add'));
	  echo $this->Html->link( 'Lista de Usuarios', array('controller' => 'usuarios', 'action' => 'index'));
	  echo $this->Html->link( 'Lista de Consultorios', array('controller' => 'consultorios', 'action' => 'index'));
	  echo $this->Html->link( 'Lista de Medicos', array('controller' => 'medicos', 'action' => 'index')); ?> </li>
</div>
<br />
<div class="decorado1">
	<div class="titulo1"><?php echo __('Turnos');?></div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('recibido', 'R');?></th>
			<th><?php echo $this->Paginator->sort('atendido', 'A');?></th>
			<th><?php echo $this->Paginator->sort('cancelado', 'C');?></th>
			<th><?php echo $this->Paginator->sort('fecha_inicio', 'Inicio');?></th>
			<th><?php echo $this->Paginator->sort('fecha_fin', 'Fin' );?></th>
			<th><?php echo $this->Paginator->sort('paciente_id');?></th>
			<th><?php echo $this->Paginator->sort('medico_id');?></th>
			<th><?php echo $this->Paginator->sort('consultorio_id');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($turnos as $turno): ?>
	<tr>
		<td><?php if( $turno['Turno']['recibido'] ) { echo "R"; } else { echo "&nbsp"; } ?>&nbsp;</td>
		<td><?php if( $turno['Turno']['atendido'] ) { echo "A"; } else { echo "&nbsp"; } ?>&nbsp;</td>
		<td><?php if( $turno['Turno']['cancelado'] ) { echo "C"; } else { echo "&nbsp"; } ?>&nbsp;</td>
		<td><?php echo date( 'd/m/y H:i', strtotime( $turno['Turno']['fecha_inicio'] ) ); ?>&nbsp;</td>
		<td><?php echo date( 'H:i',strtotime( $turno['Turno']['fecha_fin'] ) ); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($turno['Paciente']['razonsocial'], array('controller' => 'usuarios', 'action' => 'view', $turno['Paciente']['id_usuario'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($turno['Medico']['Usuario']['razonsocial'], array( 'controller' => 'medicos', 'action' => 'view', $turno['Medico']['id_medico'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($turno['Consultorio']['nombre'], array('controller' => 'consultorios', 'action' => 'view', $turno['Consultorio']['id_consultorio'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $turno['Turno']['id_turno'])); ?>
			<?php //echo $this->Html->link(__('Edit'), array('action' => 'edit', $turno['Turno']['id_turno'])); ?>
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