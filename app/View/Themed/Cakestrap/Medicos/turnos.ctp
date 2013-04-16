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
 	$("#seldia").css( 'display', 'block' );
 	$("#seldia").alert();
 } else {
 	$("#seldia").slideUp();
 }
}

function reservarTurno( turno, medico ) {
  actualizar = false;
    // Pongo los datos en el formulario
  $('#MedicoIdMedico').clone().attr( 'value', turno ).attr( 'name', 'data[Medico][id_turno]' ).appendTo("#MedicoReservarForm");
  $("input[name=id_medico]").val( medico );
  $("#MedicoRpaciente").typeahead({
  		source: '<?php echo Router::url( array( 'controller' => 'usuarios', 'action' => 'pacientes' ) ); ?>',
  		minLength: 4
  });
  
  $("#reservar").modal();
}

function sobreturno( medico, turno, hora, min ) {
 actualizar = false;
 // Seteo los datos necesarios
 //$("#MedicoSpaciente").autocomplete( { source: '<?php echo Router::url( array( 'controller' => 'usuarios', 'action' => 'pacientes' ) ); ?>' } );
 $('#MedicoIdMedico').clone().attr( 'value', turno ).attr( 'name', 'data[Medico][id_turno]' ).appendTo("#MedicoSobreturnoForm");
 $('#MedicoIdMedico').attr( 'value', medico ).appendTo("#MedicoSobreturnoForm");
 
 $("#MedicoMin").val( min );
 $("#MedicoHora").val( hora );
 
 $("#sobreturno").modal();
}

function cancelarTurno( id_turno ) {
	actualizar = false;
	$("#cancelarTurno").modal();
}

function cancelarTurnos( que ) {
	$("#MedicoIdMedico").clone().attr( 'value', que ).attr( 'name', 'data[Medico][que]' ).appendTo( "#cancelar2");
	$("#cancelar2").submit();
}

function mostrarCancelarTurnos() {
	if( $("#cancelar").css( 'display' ) == 'none' ) {
		$("#cancelar").slideDown();
		$("#cancelar").alert();
 	} else {
		$("#cancelar").slideUp();
 	}
}

$( function() { 
	if( actualizar ) {
		// No uso el reload porque si existen parametros los intentará enviar haciendo que aparezcan carteles
		$.doTimeout( 2*60*1000, function() {  if( actualizar ) { location.replace( "<?php echo Router::url( array( 'action' => 'turnos' ) ); ?>" ); } 	});
	}
});
</script>

<div class="row-fluid">
	
	<div class="navbar">
		<div class="navbar-inner">
			<ul class="nav">
				<li><?php echo $this->Html->link( 'Inicio', '/' ); ?></li>
				<li><?php echo $this->Html->tag( 'a', 'Cambiar día', array( 'id' => 'cambiarDia', 'onclick' => 'cambiarDia()' ) ); ?></li>
				<?php if( $hoy ): ?>
				<li><?php echo $this->Html->tag( 'a', 'Cancelar turnos', array( 'onclick' => 'mostrarCancelarTurnos()' ) ); ?></li>
				<?php endif; ?>
				<li><?php echo $this->Html->link( 'Pacientes', array( 'controller' => 'usuarios', 'action' => 'index' ) ); ?></li>
				<li><?php echo $this->Html->link( 'Salir', array( 'controller' => 'usuarios', 'action' => 'salir' ) ); ?></li> 
			</ul>
		</div>	
	</div>
</div>

<div id="seldia" style="display:none;" class="alert alert-info">
   <button type="button" class="close" data-dismiss="seldia">&times;</button>
   <?php echo $this->Form->create( 'Medico', array( 'action' => 'turnos', 'class' => 'form-inline' ) ); ?>
   <fieldset>
   		Elija el día que desea:
   		<?php echo $this->Form->input( 'id_medico', array( 'type' => 'hidden', 'value' => 0 ) ); ?>
   		<div class="btn-toolbar">
   			<div class="btn-group"><?php  echo $this->Html->tag( 'a', '< Dia', array(  'class' => 'btn', 'onclick' => '$("#MedicoIdMedico").clone().attr( "value", "ayer" ).attr( "name", "data[Medico][accion]" ).appendTo("#MedicoTurnosForm"); $("#MedicoTurnosForm").submit()' ) ); ?></div>&nbsp;
			<?php echo "&nbsp;<b>Fecha:</b>" . $this->Form->dateTime( 'fecha', 'DMY', null, array( 'class' => array( 'class' => 'input-small' ), 'value' => array( 'day' => $dia, 'month' => $mes, 'year' => $ano ), 'empty' => false, 'monthNames' => array( 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' ) ) ); ?>
			<?php echo $this->Html->tag( 'a', 'Ir a hoy', array( 'onclick' => '$("#MedicoIdMedic").clone().attr( "value", "hoy" ).attr( "name", "data[Medico][accion]" ).appendTo( "#MedicoTurnosFOrm"); $("#MedicoTurnosForm").submit()') ); ?>
			<?php echo $this->Form->end( array( 'label' => "Cambiar", 'div' => false, 'class' => 'btn btn-success' ) ); ?>
			&nbsp;
   			<div class="btn-group">
				<?php  echo $this->Html->tag( 'a', 'Dia >', array( 'class' => 'btn','onclick' => '$("#MedicoIdMedico").clone().attr( "value", "manana" ).attr( "name", "data[Medico][accion]" ).appendTo("#MedicoTurnosForm"); $("#MedicoTurnosForm").submit()') );?>
				<?php  echo $this->Html->tag( 'a', 'Sem >>', array( 'class' => 'btn','onclick' => '$("#MedicoIdMedico").clone().attr( "value", "sem" ).attr( "name", "data[Medico][accion]" ).appendTo("#MedicoTurnosForm"); $("#MedicoTurnosForm").submit()' ) );?>
				<?php  echo $this->Html->tag( 'a', 'Mes >>', array( 'class' => 'btn', 'onclick' => '$("#MedicoIdMedico").clone().attr( "value", "mes" ).attr( "name", "data[Medico][accion]" ).appendTo("#MedicoTurnosForm"); $("#MedicoTurnosForm").submit()') );?>			
   			</div>
   </fieldset>
</div>

<!------------------------------------------------------------->
<!------------------ RESERVAR TURNO --------------------------->
<div id="reservar" class="modal hide fade"  tabindex="-1" role="dialog" aria-labelledby="reservar" aria-hidden="true">
	<?php echo $this->Form->create( 'Medico', array( 'action' => 'reservar', 'class' => 'form-inline' ) );
		  echo $this->Form->input ( 'id_medico', array( 'type' => 'hidden', 'value' => 0 ) ); ?>
	<div class="modal-header">
		<?php echo $this->Form->button( 'x', array( 'class' => "close", 'data-dismiss' => "reservar", 'aria-hidden' => "true" ) ); ?>
		<h3 id="myModalLabel">Reservar turno</h3>
	</div>
	<div class="modal-body">
		<p>Ingrese el paciente al cual desea reservar el turno:</p>
		<?php echo $this->Form->input( 'rpaciente', array( 'label' => 'Paciente', 'div' => false, 'data-provide' => "pacientes" ) ); ?>		
	</div>
	<div class="modal-footer">
		<?php echo $this->Form->button( 'Cerrar', array( 'class' => 'btn', 'data-dismiss' => 'modal', 'aria-hidden' => true, 'div' => false ) ); ?>
		<?php echo $this->Form->submit( 'Reservar', array( 'class' => "btn btn-primary", 'div' => false ) ); ?>
  	</div>
  	<?php echo $this->Form->end(); ?>
</div>

<!----------------------------------------------------------->
<!------------------ AUTOREFRESCO --------------------------->
<div id="autorefresco" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="autorefresco" aria-hidden="true">
	<?php echo $this->Form->create( 'Medicos', array( 'action' => 'autoactualizacion', 'class' => 'form-inline' ) ); ?>
	<div class="modal-header">
		<?php echo $this->Form->button( 'x', array( 'class' => 'close', 'data-dismiss' => 'autorefresco', 'aria-hidden' => "true" ) ); ?>
		<h3>Autorefresco de pantalla</h3>
	</div>
	<div class="modal-body">
		Seleccione la opci&oacute;n de habilitacion de autorefresco
		<?php echo $this->Form->input( 'actualizacion', array( 'type' => 'hidden', 'value' => $actualizacion ) ); ?>
	</div>
	<div class="modal-footer">
		<?php echo $this->Form->button( 'Habilitado', array( 'class' => 'btn btn-success', 'onclick' => "$('#MedicosActualizacion').val( true );" ) ); ?>
		<?php echo $this->Form->button( 'Deshabilitado', array( 'class' => 'btn btn-danger', 'onclick' => "$('#MedicosActualizacion').val( false );" ) ); ?></div>
	<?php echo $this->Form->end(); ?>
</div>

<!---------------------------------------------------------------------------------------------------------->
<!---------------------------------- SOBRETURNO ------------------------------------------------------------>
<div id="sobreturno" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="sobreturno" aria-hidden="true">
	<?php echo $this->Form->create( 'Medico', array( 'action' => 'sobreturno', 'class' => 'form-inline' ) );
		  echo $this->Form->input ( 'id_medico', array( 'type' => 'hidden', 'value' => 0 ) ); ?>
	<div class="modal-header">
		<?php echo $this->Form->button( 'x', array( 'class' => 'close', 'data-dismiss' => 'modal', 'aria-hidden' => "true" ) ); ?>
		<h3>Agregar sobreturno</h3>
	</div>
	<div class="modal-body">
		Ingrese el paciente al cual desea reservar el sobreturno:
		<?php echo $this->Form->input( 'spaciente', array( 'label' => 'Paciente:', 'class' => 'input-xlarge', 'data-source' => 'pacientes' ) ); ?>
		<?php echo $this->Form->input( 'hora', array( 'class' => 'input-mini', 'label' => 'Horario de inicio:', 'div' => false ) ); ?>
		<?php echo $this->Form->input( 'min', array( 'class' => 'input-mini', 'label' => false, 'before' => ':', 'div' => false ) ); ?>
		<?php echo $this->Form->input( 'duracion', array( 'label' => 'Duración', 'after' => 'minutos', 'class' => 'input-mini', 'value' => 10 ) ); ?>
	</div>
	<div class="modal-footer">
		<?php echo $this->Form->button( 'Reservar', array( 'class' => 'btn btn-success', 'onclick' => "function() { if( $(\"#MedicoSpaciente\").val() == '' ) { alert( 'Por favor, ingrese un paciente para generar el sobreturno' ); } else { $(\"#MedicoSobreturnoForm\").submit();" ) ); ?>
		<?php echo $this->Form->button( "Cancelar", array( 'class' => 'btn btn-inverse', 'data-dismiss' => 'modal', 'aria-hidden' => "true" ) ); ?>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
</td>

<?php if( $hoy ) { ?>
<!----------------------------------------------------------------------------------------------------------->
<!--------------------------------- CANCELAR ---------------------------------------------------------------->
<div id="cancelar" style="display:none" class="alert alert-info">
	<button type="button" class="close" data-dismiss="seldia">&times;</button>
	<?php echo $this->Form->create( 'Medico', array( 'action' => 'cancelar', 'id' => 'cancelar2' ) );
		  echo $this->Form->input( 'quien', array( 'type' => 'hidden', 'value' => 'm' ) );
		  echo $this->Form->input( 'id_turno', array( 'type' => 'hidden', 'value' => -1 ) ); // Para evitar problemas luego  ?>
	Seleccione por favor que desea cancelar:
	<div class="btn-group">
		<?php echo $this->Html->tag( 'a', 'Todos los turnos hasta el final del día', array( 'class' => 'btn btn-danger', 'onclick' => 'cancelarTurnos( \'dia\' )' ) );
			  echo $this->Html->tag( 'a', 'Próximo turno', array( 'class' => 'btn btn-danger', 'onclick' => 'cancelarTurnos( \'proximo\' )' ) ); 
		      echo $this->Html->tag( 'a', 'Cancelar', array( 'class' => 'btn btn-success', 'onclick' => '$("#cancelar").slideUp()' ) ); ?>
	</div>
	<?php echo $this->Form->end(); ?> 
</div>
<?php } ?>

<!--------------------------------------------------------------------------------------------------------->
<!--------------------------------- CANCELAR UN TURNO ----------------------------------------------------->
<div id="cancelarTurno"  class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="cancelarTurno" aria-hidden="true">
	<?php echo $this->Form->create( 'Medico', array( 'action' => 'cancelar', 'class' => 'form-inline' ) ); ?>
	<div class="modal-header">
		<?php echo $this->Form->button( 'x', array( 'class' => 'close', 'data-dismiss' => 'modal', 'aria-hidden' => "true" ) ); ?>
		<h3>¿Está seguro que desea cancelar este turno?</h3>
	</div>
	<div class="modal-body">
		<p>Por favor, selecci&oacute;ne quien cancela este turno:</p>
		<?php echo $this->Form->radio( 'quien', array( 'p' => 'Paciente', 'm' => 'Médico' ), array( 'legend' => false ) ); ?>
	</div>
	<div class="modal-footer">
		<?php echo $this->Form->button( 'Si', array( 'class' => 'btn btn-danger', 'onclick' => "$(\"#MedicoIdMedico\").clone().attr( 'value', id_turno ).attr( 'name', 'data[Medico][id_turno]' ).appendTo( \"#MedicoCancelarForm\"); $(\"#MedicoCancelarForm\").submit();" ) ); ?>
		<?php echo $this->Form->button( 'No', array( 'class' => 'btn btn-success', 'onclick' => "actualizar = true;" ) ); ?>
	</div>
	<?php echo $this->Form->end(); ?>
</div>

<!------------------ LISTA DE TURNOS ----------------------------->

<div class="row-fluid">
	
	<div class="span12">
		<table class="table table-condensed table-hover">
			<tbody>
				<th colspan="4">
					Turnos para el día <?php echo $fechas; ?>
					<?php if( $actualizacion == true ) { ?>
					<span class="pull-right btn btn-success">
					<?php } else { ?>
					<span class="pull-right btn btn-inverse">
					<?php } ?>
						<?php echo $this->Html->tag('a', 
													'<i class="icon-repeat"></i>',
													array( 'data-toggle' => "modal", 'data-target' => '#autorefresco' )
													); ?> 
					</span>
				</th>
				<?php if( count( $turnos ) == 0 ) : ?>
				<tr>
					<td class="success">No hay turnos para este consultorio</td>
				</tr>
				<?php else : ?>
				<tr>
					<th>Estado</th>
					<th>Hora</th>
					<th>Paciente</th>
					<th>Acciones</th>
				</tr>
				<?php foreach( $turnos as $turno ) : ?>
				<tr>
					<td>
						<?php if( $turno['Turno']['recibido'] == true ) {
							echo $this->Html->tag( 'a', 'R', array( 'class' => 'badge badge-info' ) );
						}
						if( $turno['Turno']['atendido'] == true ) {
							echo $this->Html->tag( 'a', 'A', array( 'class' => 'badge badge-success' ) );
						}?>
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
								  echo $this->Html->link( 'Recibido', array( 'action' => 'recibido', $turno['Turno']['id_turno'] ), array( 'class' => 'btn btn-mini' ) );
								  echo $this->Html->link( 'Atendido', array( 'action' => 'atendido', $turno['Turno']['id_turno'] ), array( 'class' => 'btn btn-mini' ) );
	 							  echo $this->Html->tag( 'a', 'Cancelar', array( 'onclick' => 'cancelarTurno( '. $turno['Turno']['id_turno'].' )', 'class' => 'btn btn-mini' ) );
							} else if( $turno['Turno']['recibido'] == true && $turno['Turno']['atendido'] == false ) {
								echo $this->Html->link( 'Atendido', array( 'action' => 'atendido', $turno['Turno']['id_turno'], 'class' => 'btn btn-mini' ) );
	 							echo $this->Html->tag( 'a', 'Cancelar', array( 'onclick' => 'cancelarTurno( '. $turno['Turno']['id_turno'].' )', 'class' => 'btn btn-mini' ) );
							} 
						} else {
							if( $turno['Turno']['cancelado'] == false ) {
								echo $this->Html->tag( 'a', 'Reservar', array( 'onclick' => 'reservarTurno( '.$turno['Turno']['id_turno'].', '.$turno['Turno']['medico_id'].'  )', 'class' => 'btn btn-mini' ) );
	 							echo $this->Html->tag( 'a', 'Cancelar', array( 'onclick' => 'cancelarTurno( '. $turno['Turno']['id_turno'].' )', 'class' => 'btn btn-mini' ) );
							}
						}
						echo $this->Html->tag( 'a', 'Sobre Turno', array( 'onclick' => 'sobreturno( '.$turno['Turno']['medico_id'].
																									', '.$turno['Turno']['id_turno'].
																									', '. date( "H", strtotime( $turno['Turno']['fecha_inicio'] ) ).
																									', '. date( "i", strtotime( $turno['Turno']['fecha_inicio'] ) ) .' )',
																		  'class' => 'btn btn-mini' ) );
					?>
				    </td>		
				</tr>
				<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
	
</div>