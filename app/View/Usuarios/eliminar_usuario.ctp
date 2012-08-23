<?php
$this->set( 'title_for_layout', "Darse de baja" );
?>
<div class="decorado1">
	<div class="titulo1">Darse de baja del sistema</div>
	Por favor ingrese la casilla de correo con que se dió de alta al sistema para dar de baja el usuario asociado.
	<?php
	echo $this->Form->create( 'Usuario', array( 'action' => 'eliminarUsuario' ) );
	echo $this->Form->input( 'email', array( 'label' => 'Correo electronico' ) );
	echo $this->Form->end( 'Dar de baja' );
	?>
	<br />
	<div class="ui-state-error ui-corner-all">
		<br />
		<span style="font-size: 16px;"><b>ATENCION:</b>&nbsp; Este proceso es irreversible!<br /></span>
		Esta acción eliminará todos los datos personales y reservas a futuro y pasado que el usuario tenga asociado!<br />
		<br />
	</div>
</div>
