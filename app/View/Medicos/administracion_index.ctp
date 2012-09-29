<?php $this->set( 'title_for_layout', "Listado de medicos" ); ?>
<div id="accion">
	<?php echo $this->Html->link( 'Nuevo Medico', array( 'action' => 'add' ) ); ?>
	<?php echo $this->Html->link( 'Lista de Obras Sociales', array( 'controller' => 'obras_sociales', 'action' => 'index' ) ); ?>
	<!-- <?php echo $this->Html->link( 'Lista de Grupos', array('controller' => 'grupos', 'action' => 'index')); ?> -->
	<?php echo $this->Html->link( 'Lista de Medicos', array( 'controller' => 'medicos', 'action' => 'index' ) ); ?>
	<?php echo $this->Html->link( 'Lista de Secretarias', array( 'controller' => 'secretarias', 'action' => 'index' ) ); ?>
</div>
<br />

<h2>Listado de medicos</h2>
<table cellpadding="0" cellspacing="0">
<tr>
		<th><?php echo $this->Paginator->sort('Usuario.email', 'Email');?></th>
		<!-- <th><?php echo $this->Paginator->sort('Usuario.razonsocial', 'Nombre');?></th> -->
		<th><?php echo $this->Paginator->sort('Especialidad.nombre', 'Especialidad');?></th>
		<!-- <th><?php echo $this->Paginator->sort('Clinica.nombre', 'Clinica' );?></th> -->
		<!-- <th><?php echo $this->Paginator->sort('Usuario.celular', 'Celular');?></th> -->
		<th class="actions">Acciones</th>
</tr>
<?php
foreach ( $medicos as $medico): ?>
<tr>
	<td><?php echo $this->Html->link( h($medico['Usuario']['email']), 'mailto:'.$medico['Usuario']['email'] ); ?>&nbsp;</td>
	<!-- <td><?php echo h($medico['Usuario']['razonsocial']); ?>&nbsp;</td> -->
	<td><?php echo $this->Html->link( h($medico['Especialidad']['nombre']), array( 'controller' => 'especialidades', 'action' => 'view', $medico['Especialidad']['id_especialidad'] ) ); ?>&nbsp;</td>
	<!-- <td><?php echo $this->Html->link( h($medico['Clinica']['nombre']), array( 'controller' => 'clinicas', 'action' => 'view', $medico['Clinica']['id_clinica'] ) ); ?>&nbsp;</td> -->
	<!-- <td><?php echo h($medico['Usuario']['celular']); ?>&nbsp;</td> -->
	<td class="actions">
		<?php echo $this->Html->link( 'Ver', array( 'action' => 'view', $medico['Medico']['id_medico'] ) ); ?>
		<?php echo $this->Html->link( 'Editar', array( 'action' => 'edit', $medico['Medico']['id_medico'] ) ); ?>
		<?php echo $this->Html->link( 'Disp', array( 'action' => 'disponibilidad', $medico['Medico']['id_medico'] ) ); ?>
		<!-- <?php echo $this->Html->link( 'Excepciones', array( 'action' => 'excepciones', $medico['Medico']['id_medico'] ) ); ?> -->
		<?php echo $this->Html->link( 'Turnos', array( 'controller' => 'turnos', 'action' => 'verPorMedico', $medico['Medico']['id_medico'] ) ); ?>
		<?php echo $this->Form->postLink( 'Eliminar', array('action' => 'delete', $medico['Usuario']['id_usuario']), null, __('Are you sure you want to delete # %s?', $medico['Usuario']['id_usuario'])); ?>
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