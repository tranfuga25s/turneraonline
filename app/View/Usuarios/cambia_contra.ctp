<?php $this->set( 'title_for_layout', "Cambiar contraseña" ); ?>
<br />

<?php echo $this->Form->create( 'Usuario' ); ?>
<fieldset>
	<legend><h2>Cambiar contraseña de Usuario</h2></legend>
	<h3><b>Usuario:</b>&nbsp; <?php echo $data['Usuario']['razonsocial']; ?></h3>
<?php
echo $this->Form->input( 'id_usuario', array( 'type' => 'hidden', 'value' => $data['Usuario']['id_usuario'] ) );
echo $this->Form->input( 'contra', array( 'type' => 'password', 'label' => 'Contraseña' ) );
echo $this->Form->input( 'recontra', array( 'type' => 'password', 'label' => 'Confirmar Contraseña' ) );
echo $this->Form->end( 'Cambiar' );
?>
</fieldset>