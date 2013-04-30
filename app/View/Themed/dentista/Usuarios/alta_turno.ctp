<?php $this->set( 'title_for_layout', "Dar de alta usuario y reservar turno" );  ?>
<script>
	function generarEmail() {
		var nombre = $("input[type=text]#UsuarioNombre" ).val();
		var apellido = $("input[type=text]#UsuarioApellido" ).val();
		if( nombre == '' || apellido == '' ) {
			$("#aviso").dialog({ buttons: { "Ok": function() { $(this).dialog("close"); } } } );
			return;			
		}
		var email = nombre+apellido+"@<?php echo substr( $dominio, 4, strlen($dominio) ); ?>";
		$("input[type=text]#UsuarioEmail").val( email );
		$("input[type=password]#UsuarioContra").val( email );
		$("input[type=password]#UsuarioConfirmacontra").val( email );
	}
	
	$( function() { $("#botonemail").button(); });
</script>
<div class="decorado1">
	<?php echo $this->Form->create('Usuario');?>
	<div class="titulo1">Agregar Nuevo Usuario</div>
	<fieldset>
	<?php

		echo $this->Form->input( 'apellido', array( 'value' => $nombre ) );
		echo $this->Form->input( 'nombre' );
	    echo $this->Form->input( 'email', array( 'after' => $this->Html->tag( 'a','No posee email', array( 'onclick' => 'generarEmail()', 'id' => 'botonemail' ) ) ) );
		echo $this->Form->input( 'telefono' );
		echo $this->Form->input( 'celular' );
		echo $this->Form->input( 'obra_social_id', array( 'options' => $obras_sociales, 'empty' => 'Ninguna' ) );
		echo $this->Form->input( 'notificaciones', array( 'type' => 'hidden', 'value' => true ) );
		echo $this->Form->input( 'contra', array( 'type' => 'password', 'label' => 'Contraseña' ) );
		echo $this->Form->input( 'confirmacontra', array( 'type' => 'password', 'label' => 'Confirmar contraseña' ) );
		echo $this->Form->input( 'grupo_id', array( 'type' => 'hidden', 'value' => 4 ) );
		echo $this->Form->input( 'id_turno', array( 'type' => 'hidden', 'value' => $id_turno ) );
		echo $this->Form->input( 'id_medico', array( 'type' => 'hidden', 'value' => $id_medico ) );
		echo $this->Form->input( 'secretaria', array( 'type' => 'hidden', 'value' => $secretaria ) );
	?>
	</fieldset>
<?php echo $this->Form->end( 'Dar de alta y reservar turno' ); ?>
</div>
<div id="aviso" title="Faltan datos" style="display: none;">Para generar un correo electronico es necesario que ingrese el nombre y el apellido del paciente. Se generará una direccion nombreapellido@alejandrotalin.com.ar para el usuario</div>
