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
<script>
	function confirmacion() {
		$("#confirmacion").dialog( {
			width: 450,
			height: 150,
			modal: true,
			buttons: {
				"Guardar": function() {
					$("#MedicoDisponibilidadForm").submit();
					$(this).dialog("close");
				},
				"Cancelar": function() {
					$(this).dialog( "close" );
				}
			}
		} );
	}
</script>

<div class="row-fluid">
	
	<div class="navbar">
		<div class="navbar-inner">
			<ul class="nav">
				<li><?php echo $this->Html->link( 'Inicio', '/' ); ?></li>
				<li><?php echo $this->Html->link( 'Turnos del día', array( 'action' => 'turnos' ) ); ?></li>
				<li><?php echo $this->Html->link( 'Pacientes', array( 'controller' => 'usuarios', 'action' => 'index' ) ); ?></li>
				<li><?php echo $this->Html->link( 'Salir', array( 'controller' => 'usuarios', 'action' => 'salir' ) ); ?></li> 
			</ul>
		</div>	
	</div>

	<div class="span12">
		<!-- Vista de disponibilidad de un medico -->
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
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>
							<th rowspan="2">Día de la semana</th>
							<th rowspan="2">Habilitado</th>
							<th colspan="2">Mañana</th>
							<th colspan="2">Tarde</th>
						</tr>
						<tr>
							<th>Inicio</th>
							<th>Fin</th>
							<th>Inicio</th>
							<th>Fin</th>
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
								<td><?php echo ucfirst( $dia ); echo $this->Form->input( $dia.'.numero'      , array( 'type' => 'hidden', 'value' => array_search( $dia, $dias ) ) ); ?></td>
								<td><?php echo $this->Form->input( $dia, array( 'type' => 'checkbox', 'label' => false, 'default' => $datosdia['habilitado'] ) ); ?></td>
								<td>
									<?php echo $this->Form->input( $dia.'.hinicio'     , array( 'options' => $horas  , 'label' => false, 'div' => false, 'default' => $datosdia['hora_inicio']         , 'class' => 'input-mini' ) );
										  echo "<b>:</b>";
										  echo $this->Form->input( $dia.'.minicio'     , array( 'options' => $minutos, 'label' => false, 'div' => false, 'default' => $datosdia['minuto_inicio']       , 'class' => 'input-mini' ) ); ?>
								</td>
								<td>
									<?php echo $this->Form->input( $dia.'.hfin'        , array( 'options' => $horas  , 'label' => false, 'div' => false, 'default' => $datosdia['hora_fin']            , 'class' => 'input-mini' ) );
										  echo "<b>:</b>";
										  echo $this->Form->input( $dia.'.mfin'        , array( 'options' => $minutos, 'label' => false, 'div' => false, 'default' => $datosdia['minuto_fin']          , 'class' => 'input-mini' ) ); ?>
								</td>
								<td>
									<?php echo $this->Form->input( $dia.'.hiniciotarde', array( 'options' => $horast , 'label' => false, 'div' => false, 'default' => $datosdia['hora_inicio_tarde']   , 'class' => 'input-mini' ) );
										  echo "<b>:</b>";
										  echo $this->Form->input( $dia.'.miniciotarde', array( 'options' => $minutos, 'label' => false, 'div' => false, 'default' => $datosdia['minuto_inicio_tarde'] , 'class' => 'input-mini' ) ); ?>
								</td>
								<td>
									<?php echo $this->Form->input( $dia.'.hfintarde'   , array( 'options' => $horast , 'label' => false, 'div' => false, 'default' => $datosdia['hora_fin_tarde']      , 'class' => 'input-mini' ) );
										  echo "<b>:</b>";
										  echo $this->Form->input( $dia.'.mfintarde'   , array( 'options' => $minutos, 'label' => false, 'div' => false, 'default' => $datosdia['minuto_fin_tarde']    , 'class' => 'input-mini' ) ); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<div class="form-actions">
					<?php echo $this->Html->tag( 'a', 'Guardar', array( 'onclick' => 'confirmacion()', 'id' => "boton", 'class' => 'btn btn-success' ) ); ?>
				</div>
			</fieldset>
		</fieldset>
		<?php echo $this->Form->end(); ?>		
	</div>


</div>








<div id="confirmacion" style="display: none;" title="¿Esta seguro?">
	&iquest; Est&aacute; seguro que desea modificar la disponibilidad del m&eacute;dico?<br />
	Esto regenerar&aacute; todos sus turnos desde ahora en adelante.
</div>

<script type="text/javascript" language="JavaScript">

String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

function habilitarDeshabilitarDia( dia ) {
	// busco si está seleccionado
	if( $("#Medico"+dia.capitalize() ).is( ":checked" ) ) {
		$("#"+dia+" select" ).removeAttr( "disabled" );
	} else {
		$("#"+dia+" select" ).attr( "disabled", true );
	}
}

$( function(){
	$("#MedicoDomingo"  ).bind( 'click', function() { habilitarDeshabilitarDia( 'domingo'   ) } );
	$("#MedicoSabado"   ).bind( 'click', function() { habilitarDeshabilitarDia( 'sabado'    ) } );
	$("#MedicoViernes"  ).bind( 'click', function() { habilitarDeshabilitarDia( 'viernes'   ) } );
	$("#MedicoJueves"   ).bind( 'click', function() { habilitarDeshabilitarDia( 'jueves'    ) } );
	$("#MedicoMiercoles").bind( 'click', function() { habilitarDeshabilitarDia( 'miercoles' ) } );
	$("#MedicoMartes"   ).bind( 'click', function() { habilitarDeshabilitarDia( 'martes'    ) } );
	$("#MedicoLunes"    ).bind( 'click', function() { habilitarDeshabilitarDia( 'lunes'     ) } );
	habilitarDeshabilitarDia( 'domingo'   );
	habilitarDeshabilitarDia( 'sabado'    );
	habilitarDeshabilitarDia( 'viernes'   );
	habilitarDeshabilitarDia( 'jueves'    );
	habilitarDeshabilitarDia( 'miercoles' );
	habilitarDeshabilitarDia( 'martes'    );
	habilitarDeshabilitarDia( 'lunes'     );
});
</script>