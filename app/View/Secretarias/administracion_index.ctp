<?php $this->set( 'title_for_layout', "Listado de secretarias del sistema" ); ?>
<script>
	$( function() {
		$("a","#acciones").button();
	});
</script>
<div id="acciones">
	<?php echo $this->Html->link( 'Nueva Secretaria', array( 'action' => 'add' ) ); ?> &nbsp;
	<?php echo $this->Html->link( 'Lista de Usuarios', array( 'controller' => 'usuarios', 'action' => 'index' ) ); ?>&nbsp;
	<?php echo $this->Html->link( 'Lista de Clinicas', array( 'controller' => 'clinicas', 'action' => 'index' ) ); ?>
</div>
<br />
<div class="decorado1">
	<div class="titulo1">Secretarias</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('Usuario.razonsocial');?></th>
			<th><?php echo $this->Paginator->sort('clinica_id');?></th>
			<th><?php echo $this->Paginator->sort('resumen');?></th>
			<th class="actions">Acciones</th>
	</tr>
	<?php
	foreach ($secretarias as $secretaria): ?>
	<tr>
		<td><?php echo $this->Html->link($secretaria['Usuario']['razonsocial'], array('controller' => 'usuarios', 'action' => 'view', $secretaria['Usuario']['id_usuario'])); ?></td>
		<td>
			<?php echo $this->Html->link($secretaria['Clinica']['nombre'], array('controller' => 'clinicas', 'action' => 'view', $secretaria['Clinica']['id_clinica'])); ?>
		</td>
		<td>
		 <?php if( $secretaria['Secretaria']['resumen'] ) {
		 	echo "Si";
		 } else {
		 	echo "No";	
		 } ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link( 'Ver'   , array( 'action' => 'view', $secretaria['Secretaria']['id_secretaria'] ) ); ?>
			<?php echo $this->Html->link( 'Editar', array( 'action' => 'edit', $secretaria['Secretaria']['id_secretaria'] ) ); ?>
			<?php echo $this->Form->postLink( 'Eliminar', array('action' => 'delete', $secretaria['Secretaria']['id_secretaria'] ), null,  'Está seguro que desea eliminar esta secretaria?' ); ?>
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