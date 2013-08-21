<?php $this->set( 'title_for_layout', "Pedir nuevo turno" ); ?>

<script type="text/javascript">
// Variable que guarda la clinica
var id_clinica = -1;
// Variable que guarda la especialidad
var id_especialidad = -1;
// Variable que guarda el profesional
var id_medico = -1;
</script>

<div class="navbar">
	<div class="navbar-inner">
		<ul class="nav nav-pills">
			<li><?php echo $this->Html->link( 'Inicio', '/' ); ?></li>
			<li class="active"><?php echo $this->Html->link( 'Nuevo turno', array( 'controller' => 'turnos', 'action' => 'nuevo' ) ); ?></li>
			<li><?php echo $this->Html->link( 'Mis datos', array( 'controller' => 'usuarios', 'action' => 'view' ) ); ?></li>
			<li><?php echo $this->Html->link( 'Mis turnos', array( 'controller' => 'turnos', 'action' => 'verTurnos', $usuarioactual['id_usuario'] ) ); ?></li>
			<li><?php echo $this->Html->link( 'Salir', array( 'controller' => 'usuarios', 'action' => 'salir' ) ); ?></li>
		</ul>
	</div>
</div>

<div class="row-fluid">
	
	<div class="span3">
		<table class="table table-hover table-bordered">
			<tbody>
				<tr>
					<td colspan="2"><h4>Reservar Nuevo Turno</h4></td>
				</tr>
				<tr>
					<td width="20">Clinica:</td>
					<td id="clinica">&nbsp;</td>
				</tr>
				<tr>
					<td>Especialidad:</td>
					<td id="especialidad">&nbsp;</td>
				</tr>
				<tr>
					<td>Profesional:</td>
					<td id="medico">&nbsp;</td>
				</tr>
				<tr>
					<td>Fecha:</td>
					<td id="fecha"></td>
				</tr>
				<tr>
					<td>Hora:</td>
					<td id="hora"></td>
				</tr>
				<tr>
					<td>Paciente</td>
					<td><?php echo $this->Html->link( $usuario['razonsocial'], array( 'controller' => 'usuarios', 'action' => 'view', $usuario['id_usuario'] ) ); ?></td>
				</tr>
			</tbody>
		</table>

	</div>
	
	<div id="cambiar" class="span9 well">
	</div>

</div>




<script type="text/javascript" language="JavaScript">
/*
function cambiaronDatos() {
	var id_medico = $("#medico option:selected").val();
	var id_clinica = $("#clinica option:selected").val();
	var id_especialidad = $("#especialidad option:selected").val();
	
	if( id_especialidad == '' ) { id_especialidad = global_especialidad; }
	if( id_medico == '' ) { id_medico = global_medico; }
	if( id_clinica == '' ) { id_clinica = global_clinica; }
	if( id_clinica == undefined ) { id_clinica = global_clinica; }

	$("#cargando").dialog({ modal: true });
	// Pido los datos para actualizar el contenido
	$.ajax( { async: true,
		  data: { 'id_clinica': id_clinica,
			      'id_especialidad': id_especialidad,
			      'id_medico': id_medico
			},
		  evalScripts: true,
		  type: "post",
		  format: 'json',
		  url: '<?php echo Router::url( array( 'controller' => "turnos", 'action' => 'cargarDatos' ) ); ?>',
		  success: function ( datos, textoEstado, jqXHR ) {
			// Formato del array
			var elementos = JSON.parse( datos );
			$("#dclinica").empty().append( elementos.clinicas );
			$("#dmedico").empty().append( elementos.medicos );
			$("#despecialidad").empty().append( elementos.especialidades );
			$("#medico").bind( 'change', function() { cambiaronDatos(); } );
			$("#especialidad").bind( 'change', function() { cambiaronDatos(); } );
			$("#clinica").bind( 'change', function() { cambiaronDatos(); } );
			cargarCalendario();
			$("#cargando").dialog("destroy");
			},
		  error: function() {
			alert( 'Existió un error al bajar los datos. \n Refresque la página mediante la tecla F5.');
		       }
	} );
}

function cargarCalendario( mes, ano ) {
	
	var id_medico = $("#medico option:selected").val();
	var id_clinica = $("#clinica option:selected").val();
	var id_especialidad = $("#especialidad option:selected").val();

	if( id_especialidad == '' ) { id_especialidad = global_especialidad; }
	if( id_medico == '' ) { id_medico = global_medico; }
	if( id_clinica == '' ) { id_clinica = global_clinica; }
	if( id_clinica == undefined ) { id_clinica = global_clinica; }
	
	// Pido los datos para actualizar el contenido
	$.ajax( { async: true,
		  data: { 'id_clinica': id_clinica,
			  'id_especialidad': id_especialidad,
			  'id_medico': id_medico,
			  'mes': mes,
		 	  'ano': ano
			},
		  evalScripts: true,
		  type: "post",
		  format: 'html',
		  url:'<?php echo Router::url( array( 'controller' => "turnos", 'action' => 'cargarCalendario' ) ); ?>',
		  success: function ( datos, textoEstado, jqXHR ) {
			// Formato del array
			$("#dcalendario").empty().append( datos );
		  },
		  error: function() {
			alert( 'Existió un error al descargar los datos del calendario.\n Intente nuevamente.');
		  }
	} );
}

function cargarTurnos( ano, mes, dia ) {
	var id_medico = $("#medico option:selected").val();
	var id_clinica = $("#clinica option:selected").val();
	var id_especialidad = $("#especialidad option:selected").val();

	if( id_especialidad == '' ) { id_especialidad = global_especialidad; }
	if( id_medico == '' ) { id_medico = global_medico; }
	if( id_clinica == '' ) { id_clinica = global_clinica; }
	if( id_clinica == undefined ) { id_clinica = global_clinica; }

	$("#wdatos").slideUp( 'slow' );
	$("#wturnos").slideUp( 'slow' );
	
	$("#cargando").dialog({ modal: true });

	// Pido los datos para actualizar el contenido
	$.ajax( { async: true,
		  data: { 'id_clinica': id_clinica,
				  'id_especialidad': id_especialidad,
				  'id_medico': id_medico,
				  'ano': ano,
				  'mes': mes,
				  'dia': dia
			},
		  evalScripts: true,
		  type: "post",
		  format: 'html',
		  url:  '<?php echo Router::url( array( 'controller' => "turnos", 'action' => 'cargarTurnos' ) ); ?>',
		  success: function ( datos, textoEstado, jqXHR ) {
			// Agrego los turnos a la lista
			$("#wturnos").fadeOut( 'slow' );
			$("#dturnos").empty().append( datos );
			$("#wturnos").fadeIn( 'slow' );
			$("#cargando").dialog("destroy");
		  },
		  error: function() {
			alert( 'Existió un error al descagar la lista de turnos disponibles. \n Intente nuevamente.');
		  }
	} );
}*/

function cargarClinica() {
	$.ajax( { async: true,
		      data: { 'Turno': { 'paso': 1 } },
			  evalScripts: true,
			  type: "post",
			  format: 'json',
			  url: '<?php echo Router::url( array( 'action' => 'cargarDatos' ) ); ?>',
			  success: function ( datos, textoEstado, jqXHR ) {
			  	$("#cambiar").html( datos );
				// Formato del array
				/*var elementos = JSON.parse( datos );
				$("#clinica").empty().append( elementos.clinicas );
				$("#dmedico").empty().append( elementos.medicos );
				$("#despecialidad").empty().append( elementos.especialidades );
				$("#medico").bind( 'change', function() { cambiaronDatos(); } );
				$("#especialidad").bind( 'change', function() { cambiaronDatos(); } );
				$("#clinica").bind( 'change', function() { cambiaronDatos(); } );*/
			 },
			  error: function() {
				alert( 'No se pudo cargar los datos de las clinicas. Existió un error.\n Intente nuevamente mas tarde'); 
			 }
		} );
}

function cargaInicial() {
	cargarClinica();
	// Pido los datos para actualizar el contenido
	/*$.ajax( { async: true,
			  data: { 'id_clinica': id_clinica,
			    	  'id_especialidad': id_especialidad,
					  'id_medico': id_medico
			  },
			  evalScripts: true,
			  type: "post",
			  format: 'json',
			  url: '<?php //echo Router::url( array( 'controller' => "turnos", 'action' => 'cargarDatos' ) ); ?>',
			  success: function ( datos, textoEstado, jqXHR ) {
				// Formato del array
				var elementos = JSON.parse( datos );
				$("#dclinica").empty().append( elementos.clinicas );
				$("#dmedico").empty().append( elementos.medicos );
				$("#despecialidad").empty().append( elementos.especialidades );
				$("#medico").bind( 'change', function() { cambiaronDatos(); } );
				$("#especialidad").bind( 'change', function() { cambiaronDatos(); } );
				$("#clinica").bind( 'change', function() { cambiaronDatos(); } );
			 },
			  error: function() {
				alert( 'No se pudo cargar los datos del sistema de clinicas, medicos y especialidades. Existió un error.\n Intente nuevamente mas tarde'); 
			 }
		} );

	$.ajax( { async: true,
		  data: { 'id_clinica': 0,
			      'id_especialidad': 0,
			      'id_medico': 0,
			      'ano': 0,
			      'mes': 0
			},
		  evalScripts: true,
		  type: "post",
		  format: 'html',
		  url:  '<?php echo Router::url( array( 'controller' => "turnos", 'action' => 'cargarCalendario' ) ); ?>',
		  success: function ( datos, textoEstado, jqXHR ) {
			// Agrego los turnos a la lista
			$("#dcalendario").empty().append( datos );
			$("#cargando").dialog("destroy");
		  },
		  error: function() {
			alert( 'No se pudo descargar los datos para el calendario de turnos.\n Intente mas tarde.');
		  }
	} );*/
}

$( function() {
	cargaInicial();	
});

</script>

