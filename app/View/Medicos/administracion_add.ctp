<?php $this->set( 'title_for_layout', "Agregar nuevo médico" ); ?>
<div id="acciones">
	<?php echo $this->Html->link( 'Lista de Medicos', array( 'action' => 'index' ) );?>&nbsp;
    <?php echo $this->Html->link( 'Lista de Usuarios', array( 'controller' => 'usuarios', 'action' => 'index' ) );?>
</div>
<br />
<?php echo $this->Form->create('Medico');?>
<fieldset>
	<legend><h2>Agregar nuevo m&eacute;dico</h2></legend>
<p><b>Aclaraci&oacute;n importante:</b> Para que el usuario pueda aparecer en la lista desplegable debe estar registrado con el grupo de m&eacute;dicos.</p>
<?php
	echo $this->Form->input( 'usuario_id', array( 'label' => 'Usuario a convertir a médico', 'empty' => 'Elija un usuario' ) );
	echo $this->Form->input( 'clinica_id', array( 'empty' => 'Elija una clinica' ) );
	echo $this->Form->input( 'especialidad_id', array( 'empty' => 'Elija una especialidad' ) );
	echo $this->Form->end( 'Dar de alta' );
?>
</fieldset>

