<?php $this->set( 'title_for_layout', "Agregar nuevo consultorio" ); ?>
<script>
 $( function() { $("a", "#accion").button(); });
</script>
<div id="accion">
	<?php echo $this->Html->link(__('Nuevo Consultorio'), array('action' => 'add')); ?>
	<?php echo $this->Html->link(__('Listar Clinicas'), array('controller' => 'clinicas', 'action' => 'index')); ?>
</div>
<br />
<div class="decorado1">
	<div class="titulo1"><?php echo __('Consultorios');?></div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<!-- <th><?php echo $this->Paginator->sort('id_consultorio');?></th> -->
			<th><?php echo $this->Paginator->sort('clinica_id');?></th>
			<th><?php echo $this->Paginator->sort('nombre');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($consultorios as $consultorio): ?>
	<tr>
		<!-- <td><?php echo h($consultorio['Consultorio']['id_consultorio']); ?>&nbsp;</td> -->
		<td>
			<?php echo $this->Html->link($consultorio['Clinica']['nombre'], array('controller' => 'clinicas', 'action' => 'view', $consultorio['Clinica']['id_clinica'])); ?>
		</td>
		<td><?php echo h($consultorio['Consultorio']['nombre']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $consultorio['Consultorio']['id_consultorio'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $consultorio['Consultorio']['id_consultorio'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $consultorio['Consultorio']['id_consultorio']), null, __('Are you sure you want to delete # %s?', $consultorio['Consultorio']['id_consultorio'])); ?>
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