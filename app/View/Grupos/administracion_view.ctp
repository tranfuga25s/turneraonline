<div class="grupos view">
<h2><?php  echo __('Grupo');?></h2>
	<dl>
		<dt><?php echo __('Id Grupo'); ?></dt>
		<dd>
			<?php echo h($grupo['Grupo']['id_grupo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($grupo['Grupo']['nombre']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Grupo'), array('action' => 'edit', $grupo['Grupo']['id_grupo'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Grupo'), array('action' => 'delete', $grupo['Grupo']['id_grupo']), null, __('Are you sure you want to delete # %s?', $grupo['Grupo']['id_grupo'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Grupos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Grupo'), array('action' => 'add')); ?> </li>
	</ul>
</div>
