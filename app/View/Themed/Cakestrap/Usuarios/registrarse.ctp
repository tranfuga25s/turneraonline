<?php   $this->set( 'title_for_layout', "Registrarse" ); ?>
<script>
	$( function() {
		$("#dialogo").alert();
	});
</script>

<div class="row-fluid">

		<div id="dialogo" class="alert fade in out">
			<?php echo $this->Html->tag( 'a', '&times;', array( 'class' => 'close', 'data-dismiss' => 'alert') ); ?>
			<center>
				Si usted ya reserv&oacute; alg&uacute;n turno anteriormente a travez de nuestra secretaria, su cuenta ya fue dada de alta.<br />
				Por ejemplo, Si su nombre y apellido son Juan Martinez, deber&aacute; ingresar con:<br />
				<i>juanmartinez@<?php echo $dominio; ?></i><br /> Su contrase&ntilde;a ser&aacute;:<br />
				<i>juanmartinez</i><br />
				<?php echo $this->Html->link( 'Intentar esta opción', '/', array( 'class' => 'btn' ) ); ?>

			</center>
		</div>

	<div class="span7 well">
		<?php echo $this->Form->create('Usuario'); ?>
		<fieldset>
			<legend>Registrarse</legend>
			<p>Por favor, ingrese los siguientes datos para obtener su cuenta y poder solicitar turnos</p>
			<?php echo $this->Form->input( 'id_usuario' );
				  echo $this->Form->input( 'email' );
			      echo $this->Form->input( 'nombre' );
			      echo $this->Form->input( 'apellido' );
			      echo $this->Form->input( 'sexo', array( 'label' => 'Sexo:', 'options' => array( 'm' => 'Masculino', 'f' => 'Femenino' ) ) );
			      echo $this->Form->input( 'telefono' );
			      echo $this->Form->input( 'celular' );
				  echo $this->Form->input( 'obra_social_id', array( 'options' => $obras_sociales, 'empty' => 'Ninguna' ) );
				  echo $this->Form->input( 'notificaciones' );
				  echo $this->Form->hidden( 'grupo_id', array( 'value' => 4 ) );
				  echo "<small>Si elije esta opci&oacute;n recibirá un email antes de cada turno y un aviso cuando un turno sea cancelado</small><br /><br />";
				  echo "Contraseña:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; " . $this->Form->password( 'contra', array( 'label' => 'Contraseña' ) ) . "<br />";
				  echo "Confirmar Contrase&ntilde;a:" . $this->Form->password( 'contrarep', array( 'label' => 'Contraseña' ) );
			?>
			<hr />
			<p>Al presionar el botón de <b>Registrarme</b> usted acepta las <?php echo $this->Html->link( 'Condiciones del servicio', array( 'controller' => 'pages', 'action' => 'display', 'legal' ) ); ?></p>
		</fieldset>
		<div class="form-actions">
			<?php echo $this->Form->end( array( 'label' => 'Registrarme', 'class' => 'btn btn-success', 'div' => false ) ); ?>&nbsp;
			<?php //echo $this->Facebook->login( array( 'label' => $this->Html->tag( 'span', 'Ingresar con facebook', array( 'class' => 'btn btn-primary' ) ), 'redirect' => array( 'controller' => 'usuarios', 'action' => 'view' ) ) ); ?>&nbsp;
			<?php echo $this->Html->link( 'Volver', '/', array( 'class' => 'btn btn-inverted' ) ); ?>
		</div>
	</div>
</div>