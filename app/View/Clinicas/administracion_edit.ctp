<div class="clinicas form">
<?php echo $this->Form->create('Clinica');?>
	<fieldset>
		<legend><?php echo __('Administracion Edit Clinica'); ?></legend>
	<?php
		echo $this->Form->input('id_clinica');
		echo $this->Form->input('nombre');
		echo $this->Form->input('direccion');
		echo $this->Form->input('telefono');
		echo $this->Form->input('email');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Clinica.id_clinica')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Clinica.id_clinica'))); ?></li>
		<li><?php echo $this->Html->link(__('List Clinicas'), array('action' => 'index'));?></li>
	</ul>
</div>
