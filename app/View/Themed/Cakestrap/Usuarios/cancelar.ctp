<!-- Formulario de cancelacion de cuenta -->
<br />
<br />
<div class="decorado1">
	<div class="titulo1">Cancelar una cuenta creada</div>
	<center>
	<p>Por favor, ingrese su dirección de correo y su cuenta asociada con esa dirección de correo y cualquier otro dato que tengamos será eliminado.</p>
	<?php
		echo $this->Form->create( 'eliminar', array( 'action' => '/usuarios/cancelar/')  );
		echo $this->Form->input( 'id_usuario', array( 'type' => 'hidden', 'value' => $id_usuario ) );
		echo $this->Form->email( 'email' );
		echo $this->Form->end( 'Eliminar cuenta' );
	?>
	<p>Sepa disculpar las molestias!</p>
	</center>
</div>