<?php $this->set( 'title_for_layout', "Grupos de usuarios" ); ?>
<div id="acciones">
	<?php echo $this->Html->link( 'Nuevo Grupo', array( 'action' => 'add' ) ); ?>
</div>
<br />
<h2>Grupos</h2>
<table cellpadding="0" cellspacing="0">
<tr>
		<th><?php echo $this->Paginator->sort('nombre');?></th>
		<th class="actions">Acciones</th>
</tr>
<?php
foreach ($grupos as $grupo): ?>
<tr>
	<td><?php echo h($grupo['Grupo']['nombre']); ?>&nbsp;</td>
	<td class="actions">
		<?php echo $this->Html->link( 'Editar', array('action' => 'edit', $grupo['Grupo']['id_grupo'])); ?>
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