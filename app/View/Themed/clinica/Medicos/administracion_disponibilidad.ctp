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
	$( function() {
		$("#boton").button();		
	});

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
<div id="confirmacion" style="display: none;">
	&iexcl; seguro que desea modificar la disponibilidad del m&eacute;dico?<br />
	Esto regenerar&aacute; todos sus turnos desde ahora en adelante.
</div>
<!-- Vista de disponibilidad de un medico -->
<div id="acciones">
	<?php echo $this->Html->link( 'Datos del medico', array( 'action' => 'view', $medico['Medico']['id_medico'] ) ); ?>&nbsp;
	<?php echo $this->Html->link( 'Lista de medicos', array( 'action' => 'index' ) ); ?>
</div>
<br />
<?php echo $this->Form->create( 'Medico', array( 'method' => 'post', 'action' => 'disponibilidad' ) ); ?>
<fieldset>
	<legend><h2>Disponibilidad horaria de <?php echo $medico['Usuario']['razonsocial']; ?></h2></legend>
	<fieldset>
      <?php echo $this->Form->input( 'id_medico', array( 'type' => 'hidden', 'value' => $medico['Medico']['id_medico'] ) );
      echo $this->Form->input( 'disponibilidad_id', array( 'type' => 'hidden', 'value' => $medico['Disponibilidad']['Disponibilidad']['id_disponibilidad'] ) ); ?>
	<legend><h3>Datos generales</h3></legend>
		<?php echo $this->Form->input( 'duracion', array( 'before' => 'Duración del turno:', 'after' => 'minutos', 'value' => $medico['Disponibilidad']['Disponibilidad']['duracion'], 'label' => false ) ); ?>
		<br />
		<?php echo $this->Form->input( 'consultorio', array( 'before' => 'Atiende en:', 'options' => $consultorios, 'selected' => $medico['Disponibilidad']['Disponibilidad']['consultorio_id'], 'label' => false ) ); ?>
	</fieldset>
	<fieldset>
	<legend><h3>Horarios Semanales</h3></legend>
	<p>Seleccione los d&iacute;as que desea, y se habilitar&aacute;n los horarios de atenci&oacute;n, tanto de ma&ntilde;ana como tarde.<br /> Si no desea atender en alg&uacute;n horario, dejelo en 0.</p>
	<?php 
		unset( $medico['Usuario'] );
		$dias = array( 0 => 'domingo', 1 => 'lunes', 2 => 'martes', 3 => 'miercoles',  4 => 'jueves', 5 => 'viernes',  6 => 'sabado'  );
		foreach( $dias as $dia ) {
			if( isset( $medico['Disponibilidad']['DiaDisponibilidad'][$dia] ) ) {
				$datosdia = $medico['Disponibilidad']['DiaDisponibilidad'][$dia];
			} else {
				$datosdia = array( 'habilitado' => false,
						'hora_inicio' => 0, 'minuto_inicio' => 0,
						'hora_fin' => 0, 'minuto_fin' => 0,
						'hora_inicio_tarde' => 0, 'minuto_inicio_tarde' => 0,
						'hora_fin_tarde' => 0, 'minuto_fin_tarde' => 0
					);
			}
			echo "<!-- ".$dia." -->";
			echo $this->Form->input( $dia, array( 'type' => 'checkbox', 'label' => $dia, 'default' => $datosdia['habilitado'] ) );
			if( $datosdia['habilitado'] == true ) {
				echo "<div id=\"". ucfirst( $dia ) ."\" style=\"display: block;\">";
			} else {
				echo "<div id=\"". ucfirst( $dia ) ."\" style=\"display: none;\">";
			}
			echo "&nbsp;";
			echo $this->Form->input( $dia.'.hinicio'     , array( 'options' => $horas  , 'label' => false, 'div' => false, 'default' => $datosdia['hora_inicio'] ) );
			echo "<b>:</b>";
			echo $this->Form->input( $dia.'.minicio'     , array( 'options' => $minutos, 'label' => false, 'div' => false, 'default' => $datosdia['minuto_inicio'] ) );
			echo "&nbsp;&nbsp;hasta&nbsp;";
			echo $this->Form->input( $dia.'.hfin'        , array( 'options' => $horas  , 'label' => false, 'div' => false, 'default' => $datosdia['hora_fin']  ) );
			echo "<b>:</b>";
			echo $this->Form->input( $dia.'.mfin'        , array( 'options' => $minutos, 'label' => false, 'div' => false, 'default' => $datosdia['minuto_fin'] ) );
			echo "&nbsp;&nbsp;&nbsp;y&nbsp;&nbsp;&nbsp;";
			echo $this->Form->input( $dia.'.hiniciotarde', array( 'options' => $horast , 'label' => false, 'div' => false, 'default' => $datosdia['hora_inicio_tarde'] ) );
			echo "<b>:</b>";
			echo $this->Form->input( $dia.'.miniciotarde', array( 'options' => $minutos, 'label' => false, 'div' => false, 'default' => $datosdia['minuto_inicio_tarde'] ) );
			echo "&nbsp;&nbsp;hasta&nbsp;";
			echo $this->Form->input( $dia.'.hfintarde'   , array( 'options' => $horast , 'label' => false, 'div' => false, 'default' => $datosdia['hora_fin_tarde'] ) );
			echo "<b>:</b>";
			echo $this->Form->input( $dia.'.mfintarde'   , array( 'options' => $minutos, 'label' => false, 'div' => false, 'default' => $datosdia['minuto_fin_tarde'] ) );
			echo $this->Form->input( $dia.'.numero'      , array( 'type' => 'hidden', 'value' => array_search( $dia, $dias ) ) );
		echo "</div>";
		}
 ?></fieldset><?php
 echo $this->Html->tag( 'a', 'Guardar disponibilidad', array( 'onclick' => 'confirmacion()', 'id' => "boton" ) );
 echo $this->Form->end();
?>
</fieldset>

<script type="text/javascript" language="JavaScript">
function habilitarDeshabilitarDia( dia ) {
	// busco si está seleccionado
	if( $("#Medico"+dia).is( ":checked" ) ) {
		$("#"+dia).slideDown( 'slow' );
	} else {
		$("#"+dia).slideUp( 'slow' );
	}
	
}
$(document).ready( function(){
	$("#MedicoDomingo"  ).bind( 'click', function() { habilitarDeshabilitarDia( 'Domingo'   ) } );
	$("#MedicoSabado"   ).bind( 'click', function() { habilitarDeshabilitarDia( 'Sabado'    ) } );
	$("#MedicoViernes"  ).bind( 'click', function() { habilitarDeshabilitarDia( 'Viernes'   ) } );
	$("#MedicoJueves"   ).bind( 'click', function() { habilitarDeshabilitarDia( 'Jueves'    ) } );
	$("#MedicoMiercoles").bind( 'click', function() { habilitarDeshabilitarDia( 'Miercoles' ) } );
	$("#MedicoMartes"   ).bind( 'click', function() { habilitarDeshabilitarDia( 'Martes'    ) } );
	$("#MedicoLunes"    ).bind( 'click', function() { habilitarDeshabilitarDia( 'Lunes'     ) } );
});
</script>
