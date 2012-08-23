<div class="obrasSociales form">
<?php echo $this->Form->create('ObraSocial');?>
	<fieldset>
		<legend><?php echo __('Administracion Add Obras Sociale'); ?></legend>
	<?php
		echo $this->Form->input('nombre');
		echo $this->Form->input('direccion');
		echo $this->Form->input('telefono');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Obras Sociales'), array('action' => 'index'));?></li>
	</ul>
</div>
