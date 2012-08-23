<?php $this->set( 'title_for_layout', "Lista de secretarias" ); ?>
<script>
 $( function() { $("a", "#accion").button(); });
</script>
<div id="accion">
<?php echo $this->Html->link( 'Nueva Secretaria', array('action' => 'add'));
  	  echo $this->Html->link( 'Lista de Usuarios', array('controller' => 'usuarios', 'action' => 'index')); 
	  echo $this->Html->link( 'Lista de Clinicas', array('controller' => 'clinicas', 'action' => 'index')); ?>
</div>
<br />
<div class="decorado1">
	<div class="titulo1">Secretarias</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('usuario_id');?></th>
			<th><?php echo $this->Paginator->sort('clinica_id');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($secretarias as $secretaria): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($secretaria['Usuario']['razonsocial'], array('controller' => 'usuarios', 'action' => 'view', $secretaria['Usuario']['id_usuario'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($secretaria['Clinica']['nombre'], array('controller' => 'clinicas', 'action' => 'view', $secretaria['Clinica']['id_clinica'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $secretaria['Secretaria']['id_secretaria'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $secretaria['Secretaria']['id_secretaria']), null, __('Are you sure you want to delete # %s?', $secretaria['Secretaria']['id_secretaria'])); ?>
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