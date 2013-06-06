<?php
/**
 * Vista para dar de alta un usuario cuando se reserva automaticamente un turno
 * @author Esteban Zeller
 * @version 1
 */

$this->set( 'title_for_layout', "Dar de alta usuario y reservar turno" );
?>
<script>
	function generarEmail() {
		var nombre = $("#UsuarioNombre" ).val().toLowerCase();
		var apellido = $("#UsuarioApellido" ).val().toLowerCase();
		if( nombre == '' || apellido == '' ) {
			$("#aviso").modal();
			return;
		}
		var email = nombre+apellido+"@<?php if( strpos( "www.", $dominio ) === FALSE ) {	echo $dominio; } else { echo substr( $dominio, 4, strlen($dominio) ); } ?>";
		$("#UsuarioEmail").val( email );
		$("#UsuarioContra").val( email );
		$("#UsuarioConfirmacontra").val( email );
	}
</script>

<div class="row-fluid">

	<div class="span12 well">
		<?php echo $this->Form->create( 'Usuario' ); ?>
		<fieldset>
			<legend>Agregar un nuevo usuario con reserva de turno</legend>
			<?php
			echo $this->Form->input( 'apellido', array( 'value' => $nombre ) );
			echo $this->Form->input( 'nombre' );
		    echo $this->Form->input( 'email', array( 'after' => ' '.$this->Html->tag( 'a','No posee email', array( 'onclick' => 'generarEmail()', 'id' => 'botonemail', 'class' => 'btn btn-small' ) ) ) );
			echo $this->Form->input( 'telefono' );
			echo $this->Form->input( 'celular' );
			echo $this->Form->input( 'obra_social_id', array( 'options' => $obras_sociales, 'empty' => 'Ninguna' ) );
			echo $this->Form->input( 'notificaciones', array( 'type' => 'hidden', 'value' => true ) );
			echo $this->Form->input( 'contra', array( 'type' => 'password', 'label' => 'Contraseña' ) );
			echo $this->Form->input( 'confirmacontra', array( 'type' => 'password', 'label' => 'Confirmar contraseña' ) );
			echo $this->Form->input( 'grupo_id', array( 'type' => 'hidden', 'value' => 4 ) );
			?>
		</fieldset>
		<?php echo $this->Form->end( array( 'label' => 'Dar de alta y reservar turno', 'class' => 'btn btn-success', 'div' => array( 'class' => 'form-actions' ) ) ); ?>
	</div>
</div>
<div class="modal hide fade" id="aviso">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Faltan datos para generar el email</h3>
  </div>
  <div class="modal-body">
    <p>Para generar un correo electronico es necesario que ingrese el <b>nombre</b> y el <b>apellido</b> del paciente.</p>
	<p>Se generará una direccion <i>nombreapellido@alejandrotalin.com.ar</i> para el usuario.</p>
  </div>
</div>
