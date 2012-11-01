<p>Aqu&iacute; est&aacute; el resumen de turnos diarios para <?php echo $nombre_clinica; ?>.</p>
<br />
<b>Dia:</b> <?php echo $fecha; ?><br />
<br />
<table>
	<tbody>
		<tr>
			<th>Horario</th>
			<th>Consultorio</th>
			<th>Paciente</th>
		</tr>
	<?php foreach( $turnos as $turno ) { ?>
		<tr>
			<td>
				
			</td>
			<td><?php echo $turno['Consultorio']['nombre']; ?></td>
			<td>
				<?php if( $turno['Turno']['paciente_id'] ) { ?>
					&nbsp;
				<?php } else {
					echo $turno['Paciente']['razonsocial']."&nbsp;";
					  } ?>
			</td>
		</tr>
	<?php } // Fin repeticion turnos ?>
	</tbody>
</table>
<br />
Recuerde que los turnos listados arriba son v&aacute;lidos solamente hasta la fecha de generaci&oacute;n indicada debajo:<br />
<b>Hora de generaci&oacute;n:</b>&nbsp;<?php echo date("H:i:s"); ?><br />
<br />
<small>Por favor, no responda a este email, ha sido generado autom&aacute;ticamente por el sistema.</small><br />
<small>Si desea realizar alg&uacute;n cambio sobre este mensaje autom&aacute;tico, comuniquese con <?php echo $this->Html->link( 'Servicio T&eacute;cnico', 'emailto:tranfuga25s@gmail.com' ); ?></small>
