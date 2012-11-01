<?php
if( count( $turnos ) <= 0 ) {
?>
<table>
 <tbody>
  <tr>
   <th colspan="2">Fecha del turno: <?php echo $fecha; ?></th>
   <th colspan="3">
	<div class="menu"><ul><li><a onclick="$('#wdatos').slideDown(); $('#wturnos').fadeOut();">Cambiar Fecha o m&eacute;dico</a></li></ul></div>
   </th>
  </li>
  <tr>
   <th colspan="5">No hay ning&uacute;n turno disponible para el d&iacute;a seleccionado.<br />C&aacute;mbie la fecha para buscar turnos disponibles.</th>
  </tr>
 </tbody>
</table>
<?php
} else {
?>
<table>
 <tbody>
  <tr>
   <th colspan="2">Fecha del turno: <?php echo $fecha; ?></th>
   <th colspan="3">
	<div class="menu"><ul><li><a onclick="$('#wdatos').slideDown(); $('#wturnos').fadeOut();">Cambiar Fecha o m&eacute;dico</a></li></ul></div>
   </th>
  </li>
  <tr>
   <th>Horario</th>
   <th>Duraci&oacute;n</th>
   <th>Consultorio</th>
   <!--<th>Medico</th>-->
   <th>Acci&oacute;n</th>
  </tr>
<?php
foreach( $turnos as $turno ) { 
	if( $turno['Turno']['cancelado'] == false || $turno['Turno']['paciente_id'] != null || $turno['Turno']['paciente_id'] != 0 ) {
	?>
   <tr>
	<td><?php echo $turno['Turno']['hora']. ':' . $turno['Turno']['minuto']; ?></td>
	<td><?php echo $turno['Turno']['duracion']; ?> min.</td>
	<td><?php echo $turno['Consultorio']['nombre']; ?></td> 
	<!--<td><?php if( array_key_exists($turno['Medico']['usuario_id'], $medicos ) ) { echo $medicos[$turno['Medico']['usuario_id']]; } ?></td>-->
	<td class="boton"><?php  echo $this->Html->link( 'Reservar', array( 'action' => 'reservarTurno', $turno['Turno']['id_turno'] ) ); ?></td>
   </tr>
<?php } // Sino el turno fue cancelado o reservado ya
} ?>
 </tbody>
</table>
<script>
	$(function(){ $( "a", ".boton" ).button(); });
</script>
<?php } ?>