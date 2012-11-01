<?php $this->set( 'title_for_layout', "Pedir nuevo turno" ); ?>
<script type="text/javascript" language="JavaScript">

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
}

function cargaInicial() {
	// Pido los datos para actualizar el contenido
	$("#cargando").dialog({ modal: true });
	$.ajax( { async: true,
		  data: { 'id_clinica': 0,
		    	  'id_especialidad': 0,
				  'id_medico': 0
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
	} );
}

$( function() {
	$("a", ".menu").button();
	cargaInicial();	
});

</script>
<div style="display: none;" id="cargando" title="Cargando datos...">
	Espere por favor, cargando los datos necesarios.
</div>
<div class="menu">
	<?php echo $this->Html->link( 'Inicio', '/' ); ?>&nbsp;
	<?php echo $this->Html->link( 'Mis datos', array( 'controller' => 'usuarios', 'action' => 'view' ) ); ?>&nbsp;
	<?php echo $this->Html->link( 'Mis turnos', array( 'controller' => 'turnos', 'action' => 'verTurnos', $usuario['id_usuario'] ) ); ?>&nbsp;
	<?php echo $this->Html->link( 'Salir', array( 'controller' => 'usuarios', 'action' => 'salir' ) ); ?>
</div>
<div class="decorado1">
	<div class="titulo1">Solicitar nuevo turno</div>
	<div id="wdatos" style="display: block;">
	<table>
	 <tbody>
	  <tr>
		<td><div class="titulo2">Clinica</div></td>
		<td rowspan="8">
			<div class="titulo2">Calendario de turnos disponibles</div>
			<center>
				Por favor, selecci&oacute;ne una fecha para ver los turnos disponibles.<br />
				<div id="dcalendario"></div>
				<small>Los días que tienen habilitados turnos se encuentran subrayados.</small>
			</center>
		</td>
	  </tr>
	  <tr>
		<td><div id="dclinica"></div></td>
	  </tr>
	  <tr>
		<td><div class="titulo2">Especialidades</div></td>
	  </tr>
	  <tr>
		<td><div id="despecialidad"></div></td>
	  </tr>
	  <tr>
		<td><div class="titulo2">Profesionales</div></td>
	  </tr>
	  <tr>
		<td><div id="dmedico"></div></td>
	  </tr>
	 </tbody>
	</table>
	</div>
	<div id="wturnos" style="display: none;">
		<div class="titulo2">Elija su turno</div>
		<div id="dturnos">&nbsp;</div>
	</div>
</div>
