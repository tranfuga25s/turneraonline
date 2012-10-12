<?php 
$this->set( 'title_for_layout', 'Turnos del día' );
$this->Html->script( 'dotimeout.min', array( 'inline' => false ) ); 
?>
<script type="text/javascript" language="JavaScript">
<?php if( $actualizacion == true ) { ?>
var actualizar = true;
<?php } else { ?>
var actualizar = false;	
<?php } ?>

function cambiarDia() {
 actualizar = false;
 if( $("#seldia").css( 'display' ) == 'none' ) {
 	$("#seldia").slideDown();
 } else {
 	$("#seldia").slideUp();
 }
}

function reservarTurno( turno, medico ) {
  actualizar = false;
    // Pongo los datos en el formulario
  $('#MedicoIdMedico').clone().attr( 'value', turno ).attr( 'name', 'data[Medico][id_turno]' ).appendTo("#MedicoReservarForm");
  $("input[name=id_medico]").val( medico );
  $("#MedicoRpaciente").autocomplete( { source: '<?php echo Router::url( array( 'controller' => 'usuarios', 'action' => 'pacientes' ) ); ?>' } );
  
  $("#reservar").dialog( {
  	modal: true,
  	width: 400,
  	heigth: 300,
  	buttons:
  	{
  		"Reservar": function() {
  			if( $("#MedicoRpaciente").val() == "" ) {
  				alert( "Por favor, ingrese un paciente" );
  			} else {
  				$("#MedicoReservarForm").submit();
	  			$(this).dialog("close");  				
  			}
  		},
  		"Cancelar": function() { $(this).dialog("close"); actualizar = true; }
  	}
  });
}

function sobreturno( medico, turno, hora, min ) {
 actualizar = false;
 // Seteo los datos necesarios
 $("#MedicoSpaciente").autocomplete( { source: '<?php echo Router::url( array( 'controller' => 'usuarios', 'action' => 'pacientes' ) ); ?>' } );
 $('#MedicoIdMedico').clone().attr( 'value', turno ).attr( 'name', 'data[Medico][id_turno]' ).appendTo("#MedicoSobreturnoForm");
 $('#MedicoIdMedico').attr( 'value', medico ).appendTo("#MedicoSobreturnoForm");
 
 $("#MedicoMin").val( min );
 $("#MedicoHora").val( hora );
 
 $("#sobreturno").dialog(
 	{
 		modal: true,
 		width: 500,
 		heigth: 300,
 		buttons: 
 			{ "Reservar": function() {
 				if( $("#MedicoSpaciente").val() == '' ) {
 					alert( 'Por favor, ingrese un paciente para generar el sobreturno' );
 				} else {
 					$("#MedicoSobreturnoForm").submit();
 					$(this).dialog("close");
 				}
			},
		  "Cancelar": function() {
		  		$(this).dialog("close");
		  		actualizar = true;
		  } 				
		} 		
 	});
}

function cancelarTurno( id_turno ) {
	actualizar = false;
	$("#cancelarTurno").dialog({
		modal: true,
		width: 300,
		heigth: 50,
		buttons:
		{
			"Si": function() {
				$("#MedicoIdMedico").clone().attr( 'value', id_turno ).attr( 'name', 'data[Medico][id_turno]' ).appendTo( "#MedicoCancelarForm");
				$("#MedicoCancelarForm").submit();
				$(this).dialog("close");
			},
			"No": function() {
				actualizar = true;
				$(this).dialog("close");
			}
		}
	});
}

function cancelarTurnos( que ) {
	$("#MedicoIdMedico").clone().attr( 'value', que ).attr( 'name', 'data[Medico][que]' ).appendTo( "#cancelar2");
	$("#cancelar2").submit();
}

function mostrarCancelarTurnos() {
	if( $("#cancelar").css( 'display' ) == 'none' ) {
		$("#cancelar").slideDown();
 	} else {
		$("#cancelar").slideUp();
 	}
}

$(function(){
	$("a","#seldia").button();
	$("a","#cancelar").button();
	$("a",".accion").button();
	$("#autorefresco").click( function() {
		actualizar = false;
		$("#autorefresco-dialogo").dialog({
			modal: true,
			buttons:
			{
				"Habilitado": function() {
					$("#MedicosActualizacion" ).val( true );
					$("#MedicosTurnosForm").submit();
					$(this).dialog('close');
				},
				"Deshabilitado": function() {
					$("#MedicosActualizacion" ).val( false );
					$("#MedicosTurnosForm").submit();
					$(this).dialog('close');
				}
			}
		});
	} );
	if( actualizar ) {
		// No uso el reload porque si existen parametros los intentará enviar haciendo que aparezcan carteles
		$.doTimeout( 2*60*1000, function() {  if( actualizar ) { location.replace( "<?php echo Router::url( array( 'action' => 'turnos' ) ); ?>" ); } 	});
	}
});
</script>


<div class="accion">
<?php echo  $this->Html->link( 'Inicio', '/' ) . "&nbsp;".
			$this->Html->tag( 'a', 'Cambiar día', array( 'id' => 'cambiarDia', 'onclick' => 'cambiarDia()' ) ) . "&nbsp;";
			if( $hoy ) { echo $this->Html->tag( 'a', 'Cancelar turnos', array( 'onclick' => 'mostrarCancelarTurnos()' ) ) . "&nbsp;"; }
	  echo  $this->Html->link( 'Pacientes', array( 'controller' => 'usuarios', 'action' => 'index' ) ) . "&nbsp;".
		    $this->Html->link( 'Salir', array( 'controller' => 'usuarios', 'action' => 'salir' ) ); ?>
</div>
<br />
<div class="decorado1">

<div id="autorefresco-dialogo" style="display: none;" title="Auto refresco de pantalla">
	Seleccione la opci&oacute;n de habilitacion de autorefresco cada 2 minutos
	<?php echo $this->Form->create( 'Medicos', array( 'action' => 'turnos' ) );
	      echo $this->Form->input( 'actualizacion', array( 'type' => 'hidden', 'value' => $actualizacion ) );
		  echo $this->Form->end();
    ?>
</div>

<div id="seldia" style="display:none;" class="decorado2">
   <div class="titulo2">Elija el día que desea:</div><br />
   <?php echo $this->Form->create( 'Medico', array( 'action' => 'turnos' ) ); ?>
   <?php  echo $this->Form->input( 'id_medico', array( 'type' => 'hidden', 'value' => 0 ) ); ?>
   <table style="width: 625px; padding: 0px;"><tbody><tr>
    	<td rowspan="2" style="padding: 0px;"><?php  echo $this->Html->tag( 'a', '< Dia', array( 'onclick' => '$("#MedicoIdMedico").clone().attr( "value", "ayer" ).attr( "name", "data[Medico][accion]" ).appendTo("#MedicoTurnosForm"); $("#MedicoTurnosForm").submit()' ) ); ?></td>
		<td style="padding: 0px;"><?php  echo "<b>Fecha:</b>" . $this->Form->dateTime( 'fecha', 'DMY', null, array( 'value' => array( 'day' => $dia, 'month' => $mes, 'year' => $ano ), 'empty' => false, 'monthNames' => array( 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' ) ) ); ?></td>
		<td rowspan="2" style="padding: 0px;"><?php  echo $this->Html->tag( 'a', 'Dia >', array( 'onclick' => '$("#MedicoIdMedico").clone().attr( "value", "manana" ).attr( "name", "data[Medico][accion]" ).appendTo("#MedicoTurnosForm"); $("#MedicoTurnosForm").submit()') );?></td>
		<td rowspan="2" style="padding: 0px;"><?php  echo $this->Html->tag( 'a', 'Sem >>', array( 'onclick' => '$("#MedicoIdMedico").clone().attr( "value", "sem" ).attr( "name", "data[Medico][accion]" ).appendTo("#MedicoTurnosForm"); $("#MedicoTurnosForm").submit()' ) );?></td>
		<td rowspan="2" style="padding: 0px;"><?php  echo $this->Html->tag( 'a', 'Mes >>', array( 'onclick' => '$("#MedicoIdMedico").clone().attr( "value", "mes" ).attr( "name", "data[Medico][accion]" ).appendTo("#MedicoTurnosForm"); $("#MedicoTurnosForm").submit()') );?></td>
		<td rowspan="2">&nbsp;</td>
		<td rowspan="2" style="padding: 0px;"><?php echo $this->Html->tag( 'a', 'Ir a hoy', array( 'onclick' => '$("#MedicoIdMedic").clone().attr( "value", "hoy" ).attr( "name", "data[Medico][accion]" ).appendTo( "#MedicoTurnosFOrm"); $("#MedicoTurnosForm").submit()') ); ?></td>
	</tr><tr>
		<td style="padding: 0px;"><?php echo $this->Form->end( array( 'label' => "Cambiar", 'div' => false ) ); ?></td>
    </tr></tbody></table>
</div>

<?php 
if($hoy) { ?>
<div id="cancelar" style="display:none" class="decorado2">
	<?php echo $this->Form->create( 'Medico', array( 'action' => 'cancelar', 'id' => 'cancelar2' ) );
		  echo $this->Form->input( 'quien', array( 'type' => 'hidden', 'value' => 'm' ) );
		  echo $this->Form->input( 'id_turno', array( 'type' => 'hidden', 'value' => -1 ) ); // Para evitar problemas luego
		   ?>
	Seleccione por favor que desea cancelar:<br />
<?php echo $this->Html->tag( 'a', 'Todos los turnos hasta el final del día', array( 'onclick' => 'cancelarTurnos( \'dia\' )' ) );
	  echo $this->Html->tag( 'a', 'Próximo turno', array( 'onclick' => 'cancelarTurnos( \'proximo\' )' ) ); 
      echo $this->Html->tag( 'a', 'Cancelar', array( 'onclick' => '$("#cancelar").slideUp()' ) );
	  echo $this->Form->end(); ?> 
</div>
<?php } ?>

<div id="reservar" style="display:none" title="Reservar Turno">
<?php   echo $this->Form->create( 'Medico', array( 'action' => 'reservar' ) );
		echo $this->Form->input ( 'id_medico', array( 'type' => 'hidden', 'value' => 0 ) ); ?>
  Ingrese el paciente al cual desea reservar el turno:
  <table align="left">
   <tbody><tr>
     <td><b>Paciente:</b</td>
     <td><?php echo $this->Form->input( 'rpaciente', array( 'label' => false, 'div' => false ) ); ?></td>
   </tr></tbody>
  </table>
  <?php echo $this->Form->end(); ?>
</div>

<div id="sobreturno" style="display:none" title="Agregar sobreturno">
	<div>
  <?php echo $this->Form->create( 'Medico', array( 'action' => 'sobreturno' ) );
		echo $this->Form->input ( 'id_medico', array( 'type' => 'hidden', 'value' => 0 ) ); ?>
  Ingrese el paciente al cual desea reservar el sobreturno:
  <table align="left">
   <tbody>
    <tr>
     <td>Paciente:</td>
     <td colspan="3"><?php echo $this->Form->input( 'spaciente', array( 'label' => false, 'div' => false, 'cols' => 50, 'rows' => 1 ) ); ?></td>
    </tr><tr>
     <td><b>Horario de inicio:</b></td>
     <td width="20"><?php echo $this->Form->input( 'hora', array( 'label' => false, 'div' => false, 'cols' => 4, 'rows' => 1 ) ); ?></td>
     <td>:<?php echo $this->Form->input( 'min', array( 'label' => false, 'div' => false, 'cols' => 4, 'rows' => 1 ) ); ?></td>
     <td>&nbsp;</td>
    </tr><tr>
     <td><b>Duraci&oacute;n:</b></td>	
     <td width="20"><?php echo $this->Form->input( 'duracion', array( 'label' => false, 'div' => false, 'cols' => 4, 'rows' => 1, 'value' => 10 ) ); ?></td>
     <td colspan="2">minutos</td>
   </tbody>
  </table>
  <?php echo $this->Form->end(); ?>
  </div>
</div>

<div id="cancelarTurno" style="display: none;" title="&iquest;Esta seguro?">
	Por favor, selecci&oacute;ne quien cancela este turno:<br />
	<?php echo $this->Form->create( 'Medico', array( 'action' => 'cancelar' ) );
		  echo $this->Form->radio( 'quien', array( 'p' => 'Paciente', 'm' => 'Médico' ), array( 'legend' => false ) );
		  echo $this->Form->end(); ?>
</div>
<div style="position: relative; float: left; top: 25px; left: 5px;">
	<a class="ui-state-default ui-corner-all ui-button" id="autorefresco">
		<span class="ui-icon ui-icon-refresh"></span>
	</a>
</div>
<div class="titulo1">Turnos para el día <?php echo $fechas; ?></div>
<div id="consultorios">
<?php if( count( $turnos ) == 0 ) {
		echo "<div>No hay turnos para este consultorio.</div>";
	} else {
	?>
	<div>
	<table>
	 <tbody>
		<tr>
			<th>Estado</th>
			<th>Hora</th>
			<th>Paciente</th>
			<th>Acciones</th>
		</tr>
	<?php foreach( $turnos as $turno ) { ?>
		<tr>
			<td class="actions">
				<ul>
				<?php if( $turno['Turno']['recibido'] == true ) {
					echo $this->Html->tag( 'a', 'R', null );
				}
				if( $turno['Turno']['atendido'] == true ) {
					echo $this->Html->tag( 'a', 'A', null );
				}?></ul>&nbsp;
			</td>
			<?php 
			if( $turno['Turno']['atendido'] == true || $turno['Turno']['cancelado'] == true ) {
				echo "<td style=\" text-decoration : line-through;\">".date( "H:i", strtotime( $turno['Turno']['fecha_inicio'] ) )."</td>";
				if( $turno['Turno']['paciente_id'] == null ) {
					echo "<td>&nbsp;</td>";
				} else { echo "<td style=\" text-decoration: linethrough;\">".$this->Html->link(  $turno['Paciente']['razonsocial'], array( 'controller' => 'usuarios', 'action' => 'verPorSecretaria', $turno['Paciente']['id_usuario'] ) )."</td>"; }
			} else {
				echo "<td>".date( "H:i", strtotime( $turno['Turno']['fecha_inicio'] ) )."</td>";
				if( $turno['Turno']['paciente_id'] == null ) {
					echo "<td>&nbsp;</td>";
				} else {
					 echo "<td>".$this->Html->link(  $turno['Paciente']['razonsocial'], array( 'controller' => 'usuarios', 'action' => 'verPorSecretaria', $turno['Paciente']['id_usuario'] ) )."</td>";
   			    }
			}
			?>
			<td class="actions" style="text-align: left;">
				<?php
					if( $turno['Turno']['paciente_id'] != null ) {
						if( $turno['Turno']['recibido'] != true ) {
							  echo $this->Html->link( 'Recibido', array( 'action' => 'recibido', $turno['Turno']['id_turno'] ) );
							  echo $this->Html->link( 'Atendido', array( 'action' => 'atendido', $turno['Turno']['id_turno'] ) );
 							  echo $this->Html->tag( 'a', 'Cancelar', array( 'onclick' => 'cancelarTurno( '. $turno['Turno']['id_turno'].' )' ) );
						} else if( $turno['Turno']['recibido'] == true && $turno['Turno']['atendido'] == false ) {
							echo $this->Html->link( 'Atendido', array( 'action' => 'atendido', $turno['Turno']['id_turno'] ) );
 							echo $this->Html->tag( 'a', 'Cancelar', array( 'onclick' => 'cancelarTurno( '. $turno['Turno']['id_turno'].' )' ) );
						} 
					} else {
						if( $turno['Turno']['cancelado'] == false ) {
							echo $this->Html->tag( 'a', 'Reservar', array( 'onclick' => 'reservarTurno( '.$turno['Turno']['id_turno'].', '.$turno['Turno']['medico_id'].'  )' ) );
 							echo $this->Html->tag( 'a', 'Cancelar', array( 'onclick' => 'cancelarTurno( '. $turno['Turno']['id_turno'].' )' ) );
						}
					}
					echo $this->Html->tag( 'a', 'Sobre Turno', array( 'onclick' => 'sobreturno( '.$turno['Turno']['medico_id'].
																								', '.$turno['Turno']['id_turno'].
																								', '. date( "H", strtotime( $turno['Turno']['fecha_inicio'] ) ).
																								', '. date( "i", strtotime( $turno['Turno']['fecha_inicio'] ) ) .' )' ) );
				?>
			</td>
		</tr>
	<?php } // End foreach turnos ?>
	</tbody>
	</table>
<?php 
	} // End if turnos > 0
?>
   </div>
</div>