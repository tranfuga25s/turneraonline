<?php $this->set( 'title_for_layout', "Listado de clinicas" ); ?>
<script>
 $( function() { $("a", "#accion").button(); });
</script>
<div id="accion">
	<?php echo $this->Html->link( 'Agregar nueva clinica', array('action' => 'add')); ?>
</div>
<br />
<div class="decorado1">
	<div class="titulo1">Clinicas</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>Logo</th>
			<th><?php echo $this->Paginator->sort('nombre');?></th>
			<th><?php echo $this->Paginator->sort('direccion');?></th>
			<th class="actions">Acciones</th>
	</tr>
	<?php
	$i = 0;
	foreach ($clinicas as $clinica): ?>
	<tr>
		<td><?php if( !empty( $clinica['Clinica']['logo'] ) ) {
			echo $this->Html->image( $clinica['Clinica']['logo'], array( 'alt' => $clinica['Clinica']['nombre'], 'height' => 150 ) );
			} ?>
		&nbsp;</td>
		<td><?php echo h($clinica['Clinica']['nombre']); ?>&nbsp;</td>
		<td><?php echo h($clinica['Clinica']['direccion']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link( 'Ver', array('action' => 'view', $clinica['Clinica']['id_clinica'])); ?>
			<?php echo $this->Html->link( 'Editar', array('action' => 'edit', $clinica['Clinica']['id_clinica'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $clinica['Clinica']['id_clinica']), null, __('Are you sure you want to delete # %s?', $clinica['Clinica']['id_clinica'])); ?>
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

