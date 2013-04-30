<script>
	$( function() { 
		$("#boton").button(); 
		$("#dialogo").dialog({ autoOpen: true, buttons: { "Ok": function() { $(this).dialog("close"); } } } );
	});
</script>
<div class="decorado2">
	<div class="titulo1">Registrarse</div>
	Por favor, ingrese los siguientes datos para obtener su cuenta y poder solicitar turnos
 	<?php   $this->set( 'title_for_layout', "Registrarse" );
		echo $this->Form->create('Usuario');
		echo $this->Form->input( 'id_usuario' );
		echo $this->Form->input( 'email' );
		echo $this->Form->input( 'nombre' );
		echo $this->Form->input( 'apellido' );
		echo $this->Form->input( 'telefono' );
		echo $this->Form->input( 'celular' );
		echo $this->Form->input( 'obra_social_id', array( 'options' => $obras_sociales, 'empty' => 'Ninguna' ) );
		echo $this->Form->input( 'notificaciones' );
		echo $this->Form->hidden( 'grupo_id', array( 'value' => 4 ) );
		echo "<small>Si elije esta opci&oacute;n recibirá un email antes de cada turno y un aviso cuando un turno sea cancelado</small><br /><br />";
		echo "Contraseña:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; " . $this->Form->password( 'contra', array( 'label' => 'Contraseña' ) ) . "<br />";
		echo "Confirmar Contrase&ntilde;a:" . $this->Form->password( 'contrarep', array( 'label' => 'Contraseña' ) );
	?>
	<?php echo $this->Form->end( 'Registrarme' );?>
	<div id="dialogo" title="Atenci&oacute;on" style="display: none;">
	<center>
		Si usted ya reserv&oacute; alg&uacute;n turno anteriormente a travez de nuestra secretaria, su cuenta ya fue dada de alta.<br />
		Por ejemplo, Si su nombre y apellido son Juan Martinez, deber&aacute; ingresar con:<br />
		<i>juanmartinez@<?php echo substr( $dominio, 4, strlen($dominio)); ?></i><br /> Su contrase&ntilde;a ser&aacute;:<br />
		<i>juanmartinez</i><br />
		<?php echo $this->Html->link( 'Intentar esta opción', '/', array( 'id' => 'boton' ) ); ?>	
	</center>
	</div>
</div>