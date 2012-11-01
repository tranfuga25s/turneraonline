Aqui esta el resumen de turnos diarios para <?php echo $nombre_clinica; ?>.

Dia: <?php echo $fecha; ?>

-------------------------------------------------------------
- Horario         - Consultorio       - Paciente
-------------------------------------------------------------
<?php foreach( $turnos as $turno ) { ?>
<?php 
echo "- ".date( 'H:i', $turno['Turno']['fecha_inicio'] )." a ".date( 'H:i', $turno['Turno']['fecha_fin'] ). "  -  ".
     $turno['Consultorio']['nombre']. "  -  ";
     if( $turno['Turno']['paciente_id'] != null ) {
		echo $turno['Paciente']['razonsocial'];
	 } ?>
-------------------------------------------------------------	 
<?php } // Fin repeticion turnos ?>
Recuerde que los turnos listados arriba son validos solamente hasta la fecha de generacion indicada debajo:
Hora de generacion: <?php echo date("H:i:s"); ?>

- Por favor, no responda a este email, ha sido generado automaticamente por el sistema.
- Si desea realizar algun cambio sobre este mensaje automatico, comuniquese con el servicio tecnico.