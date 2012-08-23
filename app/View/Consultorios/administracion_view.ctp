<div class="consultorios view">
<h2><?php  echo __('Consultorio');?></h2>
	<dl>
		<dt><?php echo __('Id Consultorio'); ?></dt>
		<dd>
			<?php echo h($consultorio['Consultorio']['id_consultorio']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Clinica'); ?></dt>
		<dd>
			<?php echo $this->Html->link($consultorio['Clinica']['nombre'], array('controller' => 'clinicas', 'action' => 'view', $consultorio['Clinica']['id_clinica'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($consultorio['Consultorio']['nombre']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Consultorio'), array('action' => 'edit', $consultorio['Consultorio']['id_consultorio'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Consultorio'), array('action' => 'delete', $consultorio['Consultorio']['id_consultorio']), null, __('Are you sure you want to delete # %s?', $consultorio['Consultorio']['id_consultorio'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Consultorios'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Consultorio'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clinicas'), array('controller' => 'clinicas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Clinica'), array('controller' => 'clinicas', 'action' => 'add')); ?> </li>
	</ul>
</div>
