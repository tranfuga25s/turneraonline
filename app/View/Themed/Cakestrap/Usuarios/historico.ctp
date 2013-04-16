<?php $this->set( 'title_for_layout', "Listado historico de turnos para un paciente" ); ?>
<div id="acciones">
	<?php echo $this->Html->link( 'Volver' ); ?>
</div>
<div class="decorado1">
	<div class="titulo1">Historico de turnos</div>
	<b>Paciente:</b>&nbsp;<?php echo h($usuario['Usuario']['razonsocial'] ); ?><br />
	<table cellpadding="0" cellspacing="0"></table>
		<tbody>
			<th>Fecha del turno</th>
			<th>M&eacute;dico</th>
			<th>Consultorio</th>
			<th>Estado del turno</th>
	<?php
		foreach( $turnos as $turno ) {
			?>
			<tr>
				<td><?php echo date( 'd/m/Y H:i', strtotime( $turno['Turno']['fecha_inicio'] ) ).' a '.date( 'H:i', strtotime( $turno['Turno']['fecha_fin'] ) ); ?></td>
				<td><?php echo h( $turno['Medico']['Usuario']['razonsocial'] ); ?></td>
				<td><?php echo h( $turno['Consultorio']['nombre'] ); ?></td>
				<td>
			<?php
				if( $turno['Medico']['atendido'] ) {
					echo "Atendido";
				} else if( $turno['Medico']['cancelado'] ) {
					echo "Cancelado";
				} else if( $turno['Medico']['reservado'] ) {
					echo "Reservado";
				} else {
					echo "Desconocido";
				}
			?>
				&nbsp;</td>
			</tr>
			<?php
		}
	?>
		</tbody>
	</table>
</div>
