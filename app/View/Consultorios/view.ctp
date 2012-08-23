<div class="consultorios view">
<h2>Consultorio</h2>
	<dl>
		<dt>Clinica</dt>
		<dd>
			<?php echo $this->Html->link($consultorio['Clinica']['nombre'], array('controller' => 'clinicas', 'action' => 'view', $consultorio['Clinica']['id_clinica'])); ?>
			&nbsp;
		</dd>
		<dt>Nombre del Consultorio</dt>
		<dd>
			<?php echo h($consultorio['Consultorio']['nombre']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3>Actions</h3>
	<ul>
		<li><?php echo $this->Html->link( 'Lista de Consultorios', array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link( 'Listado de Clinicas', array('controller' => 'clinicas', 'action' => 'index')); ?> </li>
	</ul>
</div>
