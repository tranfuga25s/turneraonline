<?php 
echo $this->Form->create( 'Turno', array( 'action' => 'nuevo' ) );
echo $this->Form->input( 'paso', array( 'type' => 'hidden', 'value' => $paso ) );
echo $this->Form->input( 'id_clinica', array( 'type' => 'hidden', 'value' => -1 ) );    
?>
<fieldset>
	<legend>Seleccione una clinica</legend>
	<ul class="thumbnails">
	<?php foreach( $clinicas as $id_clinica => $clinica ) : ?>
		<li class="span3">
			<div class="thumbnail text-center">
				<?php echo $this->Html->image( 'cabecera.png', array( 'class' => 'thumbnail' ) ); ?>
				<?php echo $clinica; ?>
				<?php echo $this->Form->button( 'Elegir', array( 'class' => 'btn btn-primary', 'onclick' => 'enviar( '.$id_clinica.', "'.$this->Html->link( $clinica, array( 'controller' => 'clinicas', 'action' => 'view', $id_clinica ), array( 'target' => '_blank') ).'" )' ) ); ?>
			</div>
		</li>
	<?php endforeach; ?>	
	</ul>
</fieldset>
<script type="text/javascript">
function enviar( id_clinica, nombre ) {
	// Actualizo el valor del formulario
	$("#TurnoIdClinica").attr( 'value', id_clinica );
	// Seteo el nombre en la tabla de la derecha
	$("#clinica").html( nombre );
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
				alert( 'No se pudo cargar los datos de los médicos y especialidades. Existió un error.\n Intente nuevamente más tarde' ); 
			 }
		} );
}
</script>
<?php echo $this->Form->end(); ?>