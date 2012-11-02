<?php $this->set( 'title_for_layout', "Agregar nuevo usuario" ); ?>
<div id="acciones">
	<?php echo $this->Html->link( 'Lista de Usuarios', array( 'action' => 'index' ) ); ?>
</div>
<br />
<?php echo $this->Form->create( 'Usuario' );?>
<fieldset>
	<legend><h2>Agregar nuevo usuario</h2></legend>	
	<?php
		echo $this->Form->input( 'email' );
		echo $this->Form->input( 'nombre' );
		echo $this->Form->input( 'apellido' );
		echo $this->Form->input( 'telefono' );
		echo $this->Form->input( 'celular' );
		echo $this->Form->input( 'obra_social_id', array( 'options' => $obras_sociales ) );
		echo $this->Form->input( 'notificaciones' );
		echo $this->Form->input( 'contra', array( 'type' => 'password', 'label' => 'Contraseña' ) );
		echo $this->Form->input( 'confirmacontra', array( 'type' => 'password', 'label' => 'Confirmar contraseña' ) );
		echo $this->Form->input( 'grupo_id' );
		echo $this->Form->end( 'Agregar' );
	?>
</fieldset>
