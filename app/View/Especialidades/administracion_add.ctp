<div class="especialidades form">
<?php echo $this->Form->create('Especialidad');?>
	<fieldset>
		<legend><h2>Agregar nueva especialidad</h2></legend>
	<?php
		echo $this->Form->input('nombre');
	?>
	</fieldset>
	<?php echo $this->Form->end( 'Guardar' ); ?>
</div>