<?php $this->set( 'title_for_layout', "Listado de medicos" ); ?>
<div id="acciones">
	<?php echo $this->Html->link( 'Nuevo Medico', array( 'action' => 'add' ) ); ?>
</div>
<br />
<h2>Listado de medicos</h2>
<table cellpadding="0" cellspacing="0">
<tr>
		<th><?php echo $this->Paginator->sort('Usuario.razonsocial', 'Nombre y Apellido');?></th>
		<th><?php echo $this->Paginator->sort('Especialidad.nombre', 'Especialidad');?></th>
		<th><?php echo $this->Paginator->sort('Clinica.nombre', 'Clinica' ); ?></th>
		<th class="actions">Acciones</th>
</tr>
<?php
foreach ( $medicos as $medico): ?>
<tr>
	<td><?php echo h($medico['Usuario']['razonsocial']); ?>&nbsp;</td>
	<!-- <td><?php echo $this->Html->link( h($medico['Usuario']['email']), 'mailto:'.$medico['Usuario']['email'] ); ?>&nbsp;</td> -->
	<td><?php echo $this->Html->link( h($medico['Especialidad']['nombre']), array( 'controller' => 'especialidades', 'action' => 'view', $medico['Especialidad']['id_especialidad'] ) ); ?>&nbsp;</td>
	<td><?php echo $this->Html->link( h($medico['Clinica']['nombre']), array( 'controller' => 'clinicas', 'action' => 'view', $medico['Clinica']['id_clinica'] ) ); ?>&nbsp;</td>
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
?>
</p>

<div class="paging">
<?php
	echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
	echo $this->Paginator->numbers(array('separator' => ''));
	echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
?>
</div>