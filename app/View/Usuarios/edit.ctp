<?php $this->set( 'title_for_layout', "Editar mis datos" ); ?>
<div class="usuarios form">
<?php echo $this->Form->create('Usuario');?>
	<fieldset>
		<legend>Editar mis datos</legend>
	<?php
		echo $this->Form->input( 'id_usuario' );
		echo $this->Form->input( 'email' );
		echo $this->Form->input( 'nombre' );
		echo $this->Form->input( 'apellido' );
		echo $this->Form->input( 'sexo', array( 'label' => 'Sexo:', 'options' => array( 'm' => 'Masculino', 'f' => 'Femenino' ) ) );
		echo $this->Form->input( 'telefono' );
		echo $this->Form->input( 'celular' );
		echo $this->Form->input( 'obra_social_id', array( 'options' => $obras_sociales, 'empty' => 'Elija una obra social...' ) );
		echo $this->Form->input( 'notificaciones', array( 'label' => 'Recibir notificaciones' ) );
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3>Acciones</h3>
	<ul>
		<li><?php echo $this->Html->link( 'Mis datos', array( 'action' => 'view', $this->Form->value( 'Usuario.id_usuario' ) ) );?></li>
		<li><?php echo $this->Html->link( 'Cambiar contraseña', array( 'action' => 'cambiarContra', $this->Form->value( 'Usuario.id_usuario' ) ) ); ?></li>
		<li><?php echo $this->Html->link( 'Salir', array( 'action' => 'salir' ) ); ?></li>
	</ul>
</div>
