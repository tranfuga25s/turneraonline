<?php $this->set( 'title_for_layout', "Editar datos de usuario" ); ?>
<div id="acciones">
	<?php echo $this->Form->postLink( 'Eliminar Usuario', array( 'action' => 'delete', $this->Form->value( 'Usuario.id_usuario' ) ), null, __( 'Are you sure you want to delete # %s?', $this->Form->value( 'Usuario.id_usuario' ) ) ); ?>&nbsp;
	<?php echo $this->Html->link( 'Lista de Usuarios', array( 'action' => 'index' ) );?>&nbsp;
	<?php echo $this->Html->link( 'Lista de Grupos', array( 'controller' => 'grupos', 'action' => 'index' ) ); ?>
</div>
<br />
<?php echo $this->Form->create('Usuario'); ?>
	<fieldset>
		<legend><h2>Editar un usuario</h2></legend>
	<?php
		echo $this->Form->input( 'id_usuario'    );
		echo $this->Form->input( 'email'         );
		echo $this->Form->input( 'nombre'        );
		echo $this->Form->input( 'apellido'      );
		echo $this->Form->input( 'sexo', array( 'label' => 'Sexo:', 'options' => array( 'm' => 'Masculino', 'f' => 'Femenino' ) ) );
		echo $this->Form->input( 'telefono'      );
		echo $this->Form->input( 'celular'       );
		echo $this->Form->input( 'obra_social_id', array( 'options' => $obras_sociales ) );
		echo $this->Form->input( 'notificaciones');
		echo $this->Form->input( 'grupo_id'      );
		echo $this->Form->end( 'Guardar cambios' );
?>
</fieldset>
