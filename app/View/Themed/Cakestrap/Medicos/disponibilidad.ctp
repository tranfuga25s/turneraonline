<?php
$this->set( 'title_for_layout', "Disponibilidad horaria de ".$medico['Usuario']['razonsocial'] );


 // Creo los arrays
$horas = array();
$minutos = array();
$horast = array();

for( $i = 0; $i<14; $i++ )  { array_push( $horas, $i );  }
for( $i = 0; $i<24; $i++ )  { array_push( $horast, $i );  }
for( $i = 0; $i<60; $i++ )  { array_push( $minutos, $i ); }

if( $medico['Disponibilidad']['Disponibilidad']['duracion'] == null ) {
	$medico['Disponibilidad']['Disponibilidad']['duracion'] = 20;
}
?>
<div class="row-fluid">

	<div class="navbar">
		<div class="navbar-inner">
			<ul class="nav">
				<li><?php echo $this->Html->link( 'Inicio', array( 'controller' => 'usuarios', 'action' => 'dashboard' ) ); ?></li>
				<li><?php echo $this->Html->link( 'Turnos del día', array( 'action' => 'turnos' ) ); ?></li>
				<li><?php echo $this->Html->link( 'Pacientes', array( 'controller' => 'usuarios', 'action' => 'index' ) ); ?></li>
				<li><?php echo $this->Html->link( 'Salir', array( 'controller' => 'usuarios', 'action' => 'salir' ) ); ?></li>
			</ul>
		</div>
	</div>

	<div class="span12">
		<!-- Vista de disponibilidad de un médico -->
		<?php echo $this->Form->create( 'Medico', array( 'method' => 'post', 'action' => 'disponibilidad' ) );
		      echo $this->Form->input( 'id_medico', array( 'type' => 'hidden', 'value' => $medico['Medico']['id_medico'] ) );
		      echo $this->Form->input( 'disponibilidad_id', array( 'type' => 'hidden', 'value' => $medico['Disponibilidad']['Disponibilidad']['id_disponibilidad'] ) ); ?>
		<fieldset>
			<legend>Disponibilidad horaria de <?php echo $medico['Usuario']['razonsocial']; ?></legend>

			<fieldset>
				<legend>Datos Generales</legend>
				<?php echo $this->Form->input( 'duracion', array( 'before' => 'Duraci&oacute;n del turno:', 'after' => 'minutos', 'value' => $medico['Disponibilidad']['Disponibilidad']['duracion'], 'label' => false ) ); ?>
				<?php echo $this->Form->input( 'consultorio', array( 'before' => 'Atiende en:', 'options' => $consultorios, 'selected' => $medico['Disponibilidad']['Disponibilidad']['consultorio_id'], 'label' => false ) ); ?>
			</fieldset>

			<fieldset>
				<legend>Horario Semanal</legend>
				<?php
					unset( $medico['Usuario'] );
					$dias = array( 0 => 'domingo', 1 => 'lunes', 2 => 'martes', 3 => 'miercoles',  4 => 'jueves', 5 => 'viernes',  6 => 'sabado'  );
				?>
				<table class="table table-bordered table-hover table-condensed" style="vertical-align: middle; text-align: center; width: 70%;">
					<tbody>
						<tr>
							<th rowspan="2" style="vertical-align: middle; text-align: center;">Día de la semana</th>
							<th rowspan="2" style="vertical-align: middle; text-align: center;">Habilitado</th>
							<th colspan="2" style="vertical-align: middle; text-align: center;">Mañana</th>
							<th colspan="2" style="vertical-align: middle; text-align: center;">Tarde</th>
						</tr>
						<tr>
							<th style="vertical-align: middle; text-align: center;">Inicio</th>
							<th style="vertical-align: middle; text-align: center;">Fin</th>
							<th style="vertical-align: middle; text-align: center;">Inicio</th>
							<th style="vertical-align: middle; text-align: center;">Fin</th>
						</tr>
						<?php foreach( $dias as $dia ) : ?>
							<?php
							if( isset( $medico['Disponibilidad']['DiaDisponibilidad'][$dia] ) ) {
								$datosdia = $medico['Disponibilidad']['DiaDisponibilidad'][$dia];
							} else {
								$datosdia = array( 'habilitado' => false,
										'hora_inicio' => 0, 'minuto_inicio' => 0,
										'hora_fin' => 0, 'minuto_fin' => 0,
										'hora_inicio_tarde' => 0, 'minuto_inicio_tarde' => 0,
										'hora_fin_tarde' => 0, 'minuto_fin_tarde' => 0
									);
							} ?>
							<tr id="<?php echo $dia; ?>">
								<td style="vertical-align: middle; text-align: center;"><?php echo ucfirst( $dia ); echo $this->Form->input( $dia.'.numero'      , array( 'type' => 'hidden', 'value' => array_search( $dia, $dias ) ) ); ?></td>
								<td style="vertical-align: middle; text-align: center;"><?php echo $this->Form->input( $dia, array( 'type' => 'checkbox', 'label' => false, 'default' => $datosdia['habilitado'] ) ); ?></td>
								<td style="vertical-align: middle; text-align: center;">
									<?php echo $this->Form->input( $dia.'.hinicio'     , array( 'options' => $horas  , 'label' => false, 'div' => false, 'default' => $datosdia['hora_inicio']         , 'class' => 'input-mini' ) );
										  echo "<b>:</b>";
										  echo $this->Form->input( $dia.'.minicio'     , array( 'options' => $minutos, 'label' => false, 'div' => false, 'default' => $datosdia['minuto_inicio']       , 'class' => 'input-mini' ) ); ?>
								</td>
								<td style="vertical-align: middle; text-align: center;">
									<?php echo $this->Form->input( $dia.'.hfin'        , array( 'options' => $horas  , 'label' => false, 'div' => false, 'default' => $datosdia['hora_fin']            , 'class' => 'input-mini' ) );
										  echo "<b>:</b>";
										  echo $this->Form->input( $dia.'.mfin'        , array( 'options' => $minutos, 'label' => false, 'div' => false, 'default' => $datosdia['minuto_fin']          , 'class' => 'input-mini' ) ); ?>
								</td>
								<td style="vertical-align: middle; text-align: center;">
									<?php echo $this->Form->input( $dia.'.hiniciotarde', array( 'options' => $horast , 'label' => false, 'div' => false, 'default' => $datosdia['hora_inicio_tarde']   , 'class' => 'input-mini' ) );
										  echo "<b>:</b>";
										  echo $this->Form->input( $dia.'.miniciotarde', array( 'options' => $minutos, 'label' => false, 'div' => false, 'default' => $datosdia['minuto_inicio_tarde'] , 'class' => 'input-mini' ) ); ?>
								</td>
								<td style="vertical-align: middle; text-align: center;">
									<?php echo $this->Form->input( $dia.'.hfintarde'   , array( 'options' => $horast , 'label' => false, 'div' => false, 'default' => $datosdia['hora_fin_tarde']      , 'class' => 'input-mini' ) );
										  echo "<b>:</b>";
										  echo $this->Form->input( $dia.'.mfintarde'   , array( 'options' => $minutos, 'label' => false, 'div' => false, 'default' => $datosdia['minuto_fin_tarde']    , 'class' => 'input-mini' ) ); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<div class="form-actions">
					<?php echo $this->Html->tag( 'a', 'Guardar',
						array( 'onclick' => "$('#confirmacion').modal()", 'id' => "boton", 'class' => 'btn btn-success' ) ); ?>
				</div>
			</fieldset>
		</fieldset>
		<?php echo $this->Form->end(); ?>
	</div>


</div>

<!----------------------------------------------------------->
<!------------------ CONFIRMACION --------------------------->
<div id="confirmacion" class="modal hide fade"  tabindex="-1" role="dialog" aria-labelledby="reservar" aria-hidden="true">
	<div class="modal-header">
		<?php echo $this->Form->button( 'x', array( 'class' => "close", 'data-dismiss' => "reservar", 'aria-hidden' => "true" ) ); ?>
		<h3 id="myModalLabel">¿Está seguro?</h3>
	</div>
	<div class="modal-body">
		<p>Al aceptar los cambios de horarios de atención sucederá lo siguiente:</p>
		<ul>
			<li>Se <em>eliminarán</em> turnos a futuro no reservados.</li>
			<li>Se generar los turnos nuevos según el nuevo horario.</li>
			<li><b>Los turnos reservados que queden fuera del horario de atención nuevo se mostrarán en la proxima ventana.</b></li>
		</ul>
	</div>
	<div class="modal-footer">
		<?php echo $this->Form->button( 'Cerrar', array( 'class' => 'btn', 'data-dismiss' => 'modal', 'aria-hidden' => true, 'div' => false ) ); ?>
		<?php echo $this->Form->button( 'Cambiar Horario', array( 'class' => "btn btn-primary", 'div' => false, 'onclick' => "$('#MedicoDisponibilidadForm').submit();" ) ); ?>
  	</div>
</div>


<script type="text/javascript" language="JavaScript">

// Prototipo para capitalizar palabra
String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

function habilitarDeshabilitarDia( dia ) {
	// Busco si está seleccionado
	if( $("#Medico"+dia.capitalize() ).is( ":checked" ) ) {
		$("#"+dia+" select" ).removeAttr( "disabled" );
		$("#"+dia ).attr( "class", "success" );
	} else {
		$("#"+dia+" select" ).attr( "disabled", true );
		$("#"+dia ).removeAttr( "class" );
	}
}

$( function(){
	var dias = <?php echo json_encode( $dias ); ?>;
	$.each( dias, function( idx, val ){
		$("#Medico"+val.capitalize() ).bind( 'click', function() { habilitarDeshabilitarDia( val ); });
		habilitarDeshabilitarDia( val );
	});
});
</script>