<?php
if( $error == '' ) {
$this->set( 'title_for_layout', "Turno reservado correctamente" );
?>
<script>
	$(function(){
		$( "a", "#avisos" ).button();
	})
</script>
<!-- Se reservo el turno correctamente -->
<div class="decorado1">
	<div class="titulo1">Su turno se reserv&oacute; correctamente!</div><br />
	<table>
		<tbody>
			<tr>
				<td class="ui-state-active ui-corner-all">Datos del turno</td>
				<td class="ui-state-active ui-corner-all">Avisos</td>
			</tr>
			<tr>
				<td rowspan="3">
					Estos son los datos del turno para que tenga en cuenta:<br />
					<b>Fecha:</b>&nbsp;&nbsp;<?php echo date( 'd/m/Y', strtotime( $turno['Turno']['fecha_inicio'] ) ); ?><br />
					<b>Hora:</b>&nbsp;&nbsp; <?php echo date( 'H:i', strtotime( $turno['Turno']['fecha_inicio'] ) ); ?><br />
					<b>Consultorio:</b>&nbsp;&nbsp;<?php echo h( $turno['Consultorio']['nombre'] ); ?>&nbsp;<br />
					<b>M&eacute;dico:</b>&nbsp;&nbsp;<?php echo h( $turno['Medico']['Usuario']['razonsocial'] ); ?>&nbsp;<br />
					<b>Reservado para:</b>&nbsp;&nbsp;<?php echo h( $usuario['Usuario']['razonsocial'] ); ?><br />					
				</td>
				<td>
					Usted recibirá un aviso mediante correo electr&oacute;nico a su casilla de correo en caso de los siguientes eventos:<br />
					&nbsp;&nbsp;-&nbsp;Cancelación de turno.<br />
					&nbsp;&nbsp;-&nbsp;Turno proximo: <?php echo $tiempo; ?> hora(s) antes.
				</td>
			<tr>
				<td class="ui-state-active ui-corner-all">Acciones</td>
			</tr>
			<tr>
				<td id="avisos">
					<?php echo $this->Html->tag( 'a', 'Cambiar cantidad de horas antes', array( 'onclick' => "$('#cambiahoras').slideDown( 'slow' )" ) ); ?><br />
					<div style="display: none;" id="cambiahoras">
						Ingrese el n&uacute;mero de horas antes que desea recibir el aviso de turno pr&oacute;ximo:
						<?php
						echo $this->Form->create( 'Turno' ,array( 'action' => 'cambiarHorasAviso' ) );
						echo $this->Form->input( 'id_turno', array( 'type' => 'hidden', 'value' => $turno['Turno']['id_turno'] ) );
						echo $this->Form->input( 'horas', array( 'type' => 'numeric', 'value' => $tiempo, 'div' => false, 'label' => false ) );
						echo $this->Html->tag( 'a', 'Cerrar', array( 'type' => 'submit', 'onclick' => "$('#cambiahoras').fadeOut( 'slow' )" ) );
						echo $this->Form->end( 'Cambiar' );
					?>
					</div>
					<?php echo $this->Html->link( 'Cancelar este turno', array( 'controller' => 'turnos', 'action' => 'cancelar', $turno['Turno']['id_turno'] ) ); ?><br />
					<?php echo $this->Html->link( 'Ver todos mis turnos', array( 'controller' => 'turnos', 'action' => 'verTurnos', $usuario['Usuario']['id_usuario'] ) ); ?><br />					
				</td>
			</tr>
		</tbody>
	</table>
</div>
<?php  } else { 
$this->set( 'title_for_layout', "No se pudo reservar el turno correctamente" );
?>
<!--  Error al reservar el turno -->
<div>
	<div class="titulo1">No se pudo reservar el turno</div>
	<b>Causa:</b> &nbsp; <?php echo $error; ?>
</div>
<?php  } ?>
