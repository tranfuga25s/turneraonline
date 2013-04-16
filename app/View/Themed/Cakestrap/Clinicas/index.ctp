<?php $this->set( 'title_for_layout', "Listado de todas las clinicas" ); ?>
<div class="clinicas index">
	<h2>Listado de Cl&iacute;nicas</h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('nombre');?></th>
			<th><?php echo $this->Paginator->sort('direccion');?></th>
			<th>Tel&eacute;fono</th>
			<th class="actions">Acciones</th>
	</tr>
	<?php
	$i = 0;
	foreach ($clinicas as $clinica): ?>
	<tr>
		<td><?php echo h($clinica['Clinica']['nombre']); ?>&nbsp;</td>
		<td><?php echo h($clinica['Clinica']['direccion']); ?>&nbsp;</td>
		<td><?php echo h($clinica['Clinica']['telefono']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link( 'Ver datos', array( 'action' => 'view', $clinica['Clinica']['id_clinica'])); ?>
			<?php echo $this->Html->link( 'Pedir turno aqui', array( 'controller' => 'turnos', 'action' => 'nuevo', 'id_clinica' => $clinica['Clinica']['id_clinica'])); ?>
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
	<h3>Acciones</h3>
	<ul>
		<li><?php echo $this->Html->link( 'Pedir turno', array( 'controller' => 'turnos', 'action' => 'nuevo' ) ); ?></li>
		<li><?php echo $this->Html->link( 'Volver al inicio', '/' ); ?></li>
	</ul>
</div>
