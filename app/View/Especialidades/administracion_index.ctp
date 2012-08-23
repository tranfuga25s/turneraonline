<?php $this->set( 'title_for_layout', "Especialidades" ); ?>
<script>
 $( function() { $("a", "#accion").button(); });
</script>
<div id="accion">
	<?php echo $this->Html->link( 'Nueva Especialidad', array('action' => 'add')); ?>
</div>
<br />
<div class="decorado1">
	<div class="titulo1">Especialidades</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('nombre');?></th>
			<th class="actions">Acciones</th>
	</tr>
	<?php
	$i = 0;
	foreach ($especialidades as $especialidade): ?>
	<tr>
		<td><?php echo h($especialidade['Especialidad']['nombre']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link( 'Editar', array('action' => 'edit', $especialidade['Especialidad']['id_especialidad'])); ?>
			<?php echo $this->Form->postLink( 'Eliminar', array('action' => 'delete', $especialidade['Especialidad']['id_especialidad']), null, __('Are you sure you want to delete # %s?', $especialidade['Especialidad']['id_especialidad'])); ?>
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