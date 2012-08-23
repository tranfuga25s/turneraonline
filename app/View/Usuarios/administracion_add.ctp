<?php $this->set( 'title_for_layout', "Agregar nuevo usuario" ); ?>
<script>
$( function() { $( "a",".boton" ).button(); });
</script>
<div class="boton">
	<?php echo $this->Html->link( 'Lista de Usuarios', array( 'action' => 'index' ) ); ?>
</div>
<div class="decorado1" style="text-align: left;">
	<div class="titulo1">Agregar nuevo usuario</div>	
<?php echo $this->Form->create( 'Usuario' );?>
	<fieldset>
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
	?>
	</fieldset>
<?php echo $this->Form->end( 'Agregar' ); ?>
</div>
