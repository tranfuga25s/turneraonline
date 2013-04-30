<!-- Formulario de recuperación de contraseña -->
<script>
	$( function() { $("#boton").button(); });
</script>
<br />
<?php $this->set( 'title_for_layout', "Recuperar mi contraseña" ); ?>
<br />
<div class="decorado1">
	<div class="titulo1">Recuperar mi contrase&ntilde;a</div>
	<center>
	<p>Por favor, ingrese su direcci&oacute;n de correo y recibir&aacute; un mensaje con sus datos para ingresar al sistema.</p>
	<?php
		echo $this->Form->create( 'Recuperar' );
		echo $this->Form->email( 'email' );
		echo $this->Form->end( 'Pedir nueva contraseña' );
	?>
	</center>
	<div class="titulo2">Atenci&oacute;n</div>
	<center>
		Si usted ya reserv&oacute; alg&uacute;n turno anteriormente a travez de nuestra secretaria, su cuenta ya fue dada de alta.<br />
		Por ejemplo, Si su nombre y apellido son Juan Martinez, deber&aacute; ingresar con:<br />
		<i>juanmartinez@<?php echo substr( $dominio, 4, strlen($dominio)); ?></i><br /> Su contrase&ntilde;a ser&aacute;:<br />
		<i>juanmartinez</i><br />
		<?php echo $this->Html->link( 'Intentar esta opción', '/', array('id'=>'boton') );	?>
</div>