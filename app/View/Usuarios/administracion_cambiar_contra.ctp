<?php $this->set( 'title_for_layout', "Cambiar contraseña" ); ?>
<div class="decorado1">
	<div class="titulo1">Cambiar contraseña de Usuario</div>
	<b>Usuario:</b>&nbsp; <?php echo $data['Usuario']['razonsocial']; ?>

<?php
echo $this->Form->create( 'Usuario' );
echo $this->Form->input( 'id_usuario', array( 'type' => 'hidden', 'value' => $data['Usuario']['id_usuario'] ) );
echo $this->Form->input( 'contra', array( 'type' => 'password', 'label' => 'Contraseña' ) );
echo $this->Form->input( 'recontra', array( 'type' => 'password', 'label' => 'Confirmar Contraseña' ) );
echo $this->Form->end( 'Cambiar' );
?>
</div>