<?php 
echo $this->Form->create( 'Turno', array( 'action' => 'nuevo' ) );
echo $this->Form->input( 'paso', array( 'type' => 'hidden', 'value' => $paso ) );
echo $this->Form->input( 'id_clinica', array( 'type' => 'hidden', 'value' => $id_clinica ) );
echo $this->Form->input( 'id_especialidad', array( 'type' => 'hidden', 'value' => -1 ) );
echo $this->Form->input( 'id_medico', array( 'type' => 'hidden', 'value' => -1 ) );
?>
<fieldset>
	<legend>Seleccione una especialidad o un médico</legend>
	<div class="row-fluid">
		<div class="span4">
			<ul class="nav nav-pills nav-stacked">
				<li class="active"><a href="">Especialidades Disponibles</a></li>
			<?php foreach( $especialidades as $id_especialidad => $especialidad ) : ?>
				<li>
					<?php echo $this->Html->link( $especialidad, 
												  '#', 
												  array( 'onclick' => 
												        'enviarEspecialidad( '.$id_especialidad.', "'.$especialidad.'")' ) ); ?>
				</li>			
			<?php endforeach; ?>	
			</ul>
		</div>
		<!-- Listado de medicos -->
		<div class="span7">
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
					', array( 'onclick' => 'enviarMedico( '.$id_medico.',"'.$Medico.'" )' ) ); ?>
				</li>
			<?php endforeach; ?>	
			</ul>
		</div>
	</div>
</fieldset>
<script type="text/javascript">

function enviarEspecialidad( id_especialidad, nombre ) {
	// Actualizo el valor del formulario
	$("#TurnoIdEspecialidad").attr( 'value', id_especialidad );
	// Elimino el valor no elegido
	$("#TurnoIdMedico").remove();
	// Pongo el nombre de la especialidad
	$("#especialidad").html( nombre );
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

function enviarMedico( id_medico, nombre ) {
	// Actualizo el valor del formulario
	$("#TurnoIdMedico").attr( 'value', id_medico );
	// Elimino el elemento que no corresponde
	$("#TurnoIdEspecialidad").remove();
	// Coloco el paso que corresponde 
	$("#TurnoPaso").attr( 'value', 4 );
	// Coloco el nombre en su lugar
	$("#medico").html( nombre );
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
<?php if( isset( $nombre_clinica ) ) : ?>
<script type="text/javascript">
$("#clinica").html( '<?php echo $this->Html->link( $nombre_clinica, array( 'controller' => 'clinica', 'action' => 'view', $id_clinica ) ); ?>' );
</script>
<?php endif ?>
