<div class="consultorios index">
	<h2>Listado de Consultorios</h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('clinica_id');?></th>
			<th><?php echo $this->Paginator->sort('nombre');?></th>
			<th class="actions">Acci&oacute;nes</th>
	</tr>
	<?php
	$i = 0;
	foreach ($consultorios as $consultorio): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($consultorio['Clinica']['nombre'], array('controller' => 'clinicas', 'action' => 'view', $consultorio['Clinica']['id_clinica'])); ?>
		</td>
		<td><?php echo h($consultorio['Consultorio']['nombre']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link( 'Ver', array('action' => 'view', $consultorio['Consultorio']['id_consultorio'])); ?>
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
	<h3>Acci&oacute;nes</h3>
	<ul>
		<li><?php echo $this->Html->link( 'Listado de Clinicas', array('controller' => 'clinicas', 'action' => 'index')); ?> </li>
	</ul>
</div>
