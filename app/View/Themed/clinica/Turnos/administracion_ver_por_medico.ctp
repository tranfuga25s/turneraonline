<?php
$this->set( 'title_for_layout', "Turnos por medico" );
?>
<div class="decorado1">
	<div class="titulo1">Turnos de <?php echo $medico['Usuario']['razonsocial']; ?></div>
	Agregar paginación o cambio de día
	<table>
		<tbody>
			<tr>
				<th><?php echo $this->Paginator->sort( 'atendido' ); ?></th>
				<th><?php echo $this->Paginator->sort( 'fecha_inicio' ); ?></th>
				<th><?php echo $this->Paginator->sort( 'paciente_id' ); ?></th>
				<th><?php echo $this->Paginator->sort( 'consultorio_id' ); ?></th>
				<th>Acciones</th>
			</tr>
		<?php foreach( $turnos as $turno ) { ?>
			<tr>
				<td><?php if( $turno['Turno']['atendido'] == true ) { echo "A"; } ?></td>
				<td><?php echo date( "d/m H:i", strtotime( $turno['Turno']['fecha_inicio'] ) ); ?></td>
				<td><?php echo $turno['Paciente']['razonsocial']; ?></td>
				<td><?php echo $turno['Consultorio']['nombre']; ?></td>
				<td><?php echo "acciones"; ?></td>
			</tr>
	    <?php } ?>
		</tbody>
	</table>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
