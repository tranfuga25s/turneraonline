<div class="medicos form">
<?php echo $this->Form->create('Medico');?>
	<fieldset>
		<legend>Agregar Nuevo Medico</legend>
Aclaracion importante: Para que el usuario pueda aparecer en la lista desplegable debe estar registrado con el grupo de medicos.
	<?php
		echo $this->Form->input( 'usuario_id', array( 'label' => 'Usuario a convertir a medico', 'empty' => 'Elija un usuario' ) );
		echo $this->Form->input( 'clinica_id', array( 'empty' => 'Elija una clinica' ) );
		echo $this->Form->input( 'especialidad_id', array( 'empty' => 'Elija una especialidad' ) );
	?>
	</fieldset>
<?php echo $this->Form->end( 'Dar de alta' );?>
</div>
<div class="actions">
	<h3>Acciones</h3>
	<ul>
		<li><?php echo $this->Html->link( 'Lista de Medicos', array( 'action' => 'index' ) );?></li>
		<li><?php echo $this->Html->link( 'Lista de Usuarios', array( 'controller' => 'usuarios', 'action' => 'index' ) );?></li>
	</ul>
</div>
