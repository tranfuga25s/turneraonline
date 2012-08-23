<div class="obrasSociales view">
<h2><?php  echo __('Obras Sociale');?></h2>
	<dl>
		<dt><?php echo __('Id Obra Social'); ?></dt>
		<dd>
			<?php echo h($obrasSociale['ObrasSociale']['id_obra_social']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($obrasSociale['ObrasSociale']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Direccion'); ?></dt>
		<dd>
			<?php echo h($obrasSociale['ObrasSociale']['direccion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Telefono'); ?></dt>
		<dd>
			<?php echo h($obrasSociale['ObrasSociale']['telefono']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Obras Sociale'), array('action' => 'edit', $obrasSociale['ObrasSociale']['id_obra_social'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Obras Sociale'), array('action' => 'delete', $obrasSociale['ObrasSociale']['id_obra_social']), null, __('Are you sure you want to delete # %s?', $obrasSociale['ObrasSociale']['id_obra_social'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Obras Sociales'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Obras Sociale'), array('action' => 'add')); ?> </li>
	</ul>
</div>
