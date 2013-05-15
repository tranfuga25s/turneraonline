<?php 
echo $this->Form->create( 'Turno', array( 'action' => 'nuevo' ) );
echo $this->Form->input( 'paso', array( 'type' => 'hidden', 'value' => $paso ) );
echo $this->Form->input( 'id_clinica', array( 'type' => 'hidden', 'value' => $id_clinica ) );
echo $this->Form->input( 'id_especialidad', array( 'type' => 'hidden', 'value' => $id_especialidad ) );
echo $this->Form->input( 'id_medico', array( 'type' => 'hidden', 'value' => -1 ) );
?>
<fieldset>
	<legend>Seleccione un médico</legend>
	<!-- Listado de medicos -->
	<ul class="nav nav-pills nav-stacked">
		<li class="active"><a href="">Médicos Disponibles</a></li>
	</ul>
	<ul clas="thumbnails">
	<?php foreach( $medicos as $id_medico => $Medico ) : ?>
		<li class="span3">
			<?php echo $this->Html->tag( 'a', '
			<div class="thumbnail text-center">
				'.$this->Html->image( 'perfil-generico.jpg', array( 'width' => '88%', 'class' => 'thumbnail', 'alt' => $Medico ) ).'
				'.$Medico.'
			</div>
			', array( 'onclick' => 'enviarMedico( '.$id_medico.', \''.$this->Html->link( $Medico, array( 'controller' => 'medicos', 'action' => 'view', $id_medico ), array( 'target' => '_blank', 'escape' => false ) ).'\' )' ) ); ?>
		</li>
	<?php endforeach; ?>	
	</ul>
</fieldset>
<script type="text/javascript">
function enviarMedico( id_medico, nombre ) {
	// Actualizo el valor del formulario
	$("#TurnoIdMedico").attr( 'value', id_clinica );
	// Coloco el nombre en su lugar
	$("#medico").html( nombre );
	// Solicito el caledario
	$.ajax( { async: false,
		      data: $("#TurnoNuevoForm").serialize(),
			  evalScripts: true,
			  type: "post",
			  format: 'json',
			  url: '<?php echo Router::url( array( 'action' => 'cargarDatos' ) ); ?>',
			  success: function ( datos ) {
			  	$("#cambiar").html( datos );
			  },
			  error: function() {
				alert( 'No se pudo cargar los datos de el calendario. Existió un error.\n Intente nuevamente más tarde' ); 
			 }
		} );
}
</script>
<?php echo $this->Form->end(); ?>