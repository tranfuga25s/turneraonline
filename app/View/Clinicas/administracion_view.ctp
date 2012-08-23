<?php $this->set( 'title_for_layout', "Datos de " . $clinica['Clinica']['nombre'] ); ?>
<div class="clinicas view">
<h2><?php  echo __('Clinica');?></h2>
	<dl>
		<dt><?php echo __('Id Clinica'); ?></dt>
		<dd>
			<?php echo h($clinica['Clinica']['id_clinica']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($clinica['Clinica']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Direccion'); ?></dt>
		<dd>
			<?php echo h($clinica['Clinica']['direccion']); ?>
			&nbsp;
		</dd>
		<dt>Tel&eacute;fono</dt>
		<dd>
			<?php echo h($clinica['Clinica']['telefono']); ?>
			&nbsp;
		</dd>
		<dt>Logotipo</dt>
		<dd>
			<?php
			if( !empty( $clinica['Clinica']['logo'] ) ) {
				echo $this->Html->image( $clinica['Clinica']['logo'], array( 'alt' => $clinica['Clinica']['nombre'], 'height' => 150 ) );
			} else {
				echo "No ingreso ningun logotipo";
			} ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Clinica'), array('action' => 'edit', $clinica['Clinica']['id_clinica'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Clinica'), array('action' => 'delete', $clinica['Clinica']['id_clinica']), null, __('Are you sure you want to delete # %s?', $clinica['Clinica']['id_clinica'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Clinicas'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Clinica'), array('action' => 'add')); ?> </li>
	</ul>
</div>
