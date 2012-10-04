<?php echo $this->Form->create('Especialidad');?>
<fieldset>
	<legend><h2>Editar especialidad</h2></legend>
	<?php
		echo $this->Form->input('id_especialidad');
		echo $this->Form->input('nombre');
	?>
	</fieldset>
<?php echo $this->Form->end( 'Guardar' ); ?>
<div class="actions">
	<h2>Acciones</h3>
	<?php echo $this->Form->postLink( 'Eliminar esta especialidad', array( 'action' => 'delete', $this->Form->value('Especialidade.id_especialidad') ), null, 'Esta seguro que desea eliminar esta especialidad?' ); ?>
	<?php echo $this->Html->link( 'Lista de Especialidades', array( 'action' => 'index' ) );?>
</div>
