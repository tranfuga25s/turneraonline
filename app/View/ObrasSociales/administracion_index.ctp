<?php $this->set( 'title_for_layout', "Obras sociales" ); ?>
<div id="acciones">
	<?php echo $this->Html->link( 'Nueva Obra Social', array( 'action' => 'add' ) ); ?>
</div>
<br />
<h2>Obras Sociales</h2>
<table cellpadding="0" cellspacing="0">
<tr>
		<th><?php echo $this->Paginator->sort('nombre');?></th>
		<th><?php echo $this->Paginator->sort('direccion');?></th>
		<th><?php echo $this->Paginator->sort('telefono');?></th>
		<th class="actions">Acciones</th>
</tr>
<?php
$i = 0;
foreach ($obrasSociales as $obrasSociale): ?>
<tr>
	<td><?php echo h($obrasSociale['ObraSocial']['nombre']); ?>&nbsp;</td>
	<td><?php echo h($obrasSociale['ObraSocial']['direccion']); ?>&nbsp;</td>
	<td><?php echo h($obrasSociale['ObraSocial']['telefono']); ?>&nbsp;</td>
	<td class="actions">
		<?php echo $this->Html->link( 'Ver', array('action' => 'view', $obrasSociale['ObraSocial']['id_obra_social'])); ?>
		<?php echo $this->Html->link( 'Editar', array('action' => 'edit', $obrasSociale['ObraSocial']['id_obra_social'])); ?>
		<?php echo $this->Form->postLink( 'Eliminar', array('action' => 'delete', $obrasSociale['ObraSocial']['id_obra_social']), null, __('Are you sure you want to delete # %s?', $obrasSociale['ObraSocial']['id_obra_social'])); ?>
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