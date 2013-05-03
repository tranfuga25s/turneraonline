<?php $this->set( 'title_for_layout', "Cambiar contraseña" ); ?>
<div class="decorado1">
<?php echo $this->Form->create( 'Usuario' ); ?>
	<div class="titulo1">Cambiar contraseña de Usuario</div>
	<fieldset>
		<b>Usuario:</b>&nbsp; <?php echo $data['Usuario']['razonsocial']; ?><br />
		<?php
		echo $this->Form->input( 'id_usuario', array( 'type' => 'hidden', 'value' => $data['Usuario']['id_usuario'] ) );
		echo $this->Form->input( 'anterior', array( 'type' => 'password', 'label' => 'Contraseña Actual' ) );
		echo $this->Form->input( 'contra', array( 'type' => 'password', 'label' => 'Nueva Contraseña' ) );
		echo $this->Form->input( 'recontra', array( 'type' => 'password', 'label' => 'Confirmar Nueva Contraseña' ) );
		echo $this->Form->end( 'Cambiar' );
		?>
	</fieldset>
</div>