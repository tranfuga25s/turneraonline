<?php $this->set( 'title_for_layout', "Lista de obras sociales disponibles" ); ?>
<script>
 $( function() {
	$("a","#botones").button();
 });
</script>
<div id="botones">
	<?php echo $this->Html->link( 'Inicio', '/' );
		  echo $this->Html->link( 'Nuevo turno', array( 'controller' => 'turnos', 'action' => 'nuevo' ) );
		  echo $this->Html->link( 'Mis datos', array( 'controller' => 'usuarios', 'action' => 'view' ) ); 
		  echo $this->Html->link( 'Salir', array( 'controller' => 'usuarios', 'action' => 'salir' ) ); ?>
</div>
<br />
<div class="decorado1">
	<div class="titulo1">Listado de Obras Sociales Disponibles</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('nombre');?></th>
			<th><?php echo $this->Paginator->sort('direccion');?></th>
			<th><?php echo $this->Paginator->sort('telefono');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($obrasSociales as $obrasSociale): ?>
	<tr>
		<td><?php echo $this->Html->link( h($obrasSociale['ObraSocial']['nombre']), array('action' => 'view', $obrasSociale['ObraSocial']['id_obra_social'])); ?>&nbsp;</td>
		<td><?php echo h($obrasSociale['ObraSocial']['direccion']); ?>&nbsp;</td>
		<td><?php echo h($obrasSociale['ObraSocial']['telefono']); ?>&nbsp;</td>
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