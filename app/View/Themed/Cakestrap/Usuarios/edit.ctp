<?php $this->set( 'title_for_layout', "Editar mis datos" ); ?>
<div class="row-fluid">

	<?php echo $this->element( 'menu/usuario', array( 'usuario' => $this->request->data ) ); ?>
		
	<div class="span10 well">
		<?php echo $this->Form->create('Usuario'); ?>
		<fieldset>
			<legend>Editar mis datos</legend>
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
		</fieldset>
		<div class="form-actions">
			<?php echo $this->Form->end( array( 'label' => 'Guardar', 'class' => 'btn btn-success', 'div' => false ) ); ?>&nbsp;
		</div>
</div>
