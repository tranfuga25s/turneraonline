<div class="clinicas form">
<?php echo $this->Form->create('Clinica');?>
	<fieldset>
		<legend><?php echo __('Administracion Add Clinica'); ?></legend>
	<?php
		echo $this->Form->input('nombre', array( 'type' => 'text' ) );
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

		<li><?php echo $this->Html->link( 'Listado de Clinicas', array('action' => 'index'));?></li>
	</ul>
</div>
