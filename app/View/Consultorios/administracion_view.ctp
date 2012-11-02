<?php $this->set( 'title_for_layout', "Ver datos de un consultorio" ); ?>
<div id="acciones">
	<?php echo $this->Html->link( 'Editar este consultorio', array('action' => 'edit', $consultorio['Consultorio']['id_consultorio'])); ?> &nbsp;
	<?php echo $this->Form->postLink( 'Eliminar este consultorio', array('action' => 'delete', $consultorio['Consultorio']['id_consultorio']), null, __('Are you sure you want to delete # %s?', $consultorio['Consultorio']['id_consultorio'])); ?> &nbsp;
	<?php echo $this->Html->link( 'Lista de Consultorios', array('action' => 'index')); ?> &nbsp;
	<?php echo $this->Html->link( 'Nuevo Consultorio', array('action' => 'add')); ?> &nbsp;
	<?php echo $this->Html->link( 'Lista de Clinicas', array('controller' => 'clinicas', 'action' => 'index')); ?> &nbsp;
</div>
<br />
<h2>Consultorio</h2>
<dl>
	<dt>Identificador de Consultorio</dt>
	<dd>
		<?php echo h($consultorio['Consultorio']['id_consultorio']); ?>
		&nbsp;
	</dd>
	<dt>Clinica perteneciente</dt>
	<dd>
		<?php echo $this->Html->link($consultorio['Clinica']['nombre'], array('controller' => 'clinicas', 'action' => 'view', $consultorio['Clinica']['id_clinica'])); ?>
		&nbsp;
	</dd>
	<dt>Nombre descriptivo</dt>
	<dd>
		<?php echo h($consultorio['Consultorio']['nombre']); ?>
		&nbsp;
	</dd>
</dl>
