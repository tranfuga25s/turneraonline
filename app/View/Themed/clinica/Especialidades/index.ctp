<div class="especialidades index">
	<h2> Listado de Especialidades</h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('nombre');?></th>
			<th class="actions">Acci&oacute;nes</th>
	</tr>
	<?php
	$i = 0;
	foreach ($especialidades as $especialidade): ?>
	<tr>
		<td><?php echo h($especialidade['Especialidade']['nombre']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link( 'Ver', array('action' => 'view', $especialidade['Especialidade']['id_especialidad'])); ?>
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
		echo $this->Paginator->prev('< anterior', array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next( 'siguiente >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
