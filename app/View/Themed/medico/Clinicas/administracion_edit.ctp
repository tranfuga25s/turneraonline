<div class="clinicas form">
<?php echo $this->Form->create('Clinica');?>
	<fieldset>
		<legend><h2>Editar clinica</h2></legend>
	<?php
		echo $this->Form->input('id_clinica');
		echo $this->Form->input('nombre', array( 'type' => 'text' ) );
		echo $this->Form->input('direccion');
		echo $this->Form->input('telefono');
		echo $this->Form->input('email');
	?>
	</fieldset>
<?php echo $this->Form->end( 'Guardar');?>
</div>

