<?php 
$this->set( 'title_for_layout', "Mis turnos" ); 
?>
<div class="row-fluid">
	
	<?php echo $this->element( 'menu/usuario' ); ?>
	
	<div class="span9">
		<h4>Turnos reservados</h4>
		<?php if( count( $turnos ) <= 0 ) { ?>
			Usted no posee ningun turno pr&oacute;ximo.<br /><br />
		<?php } else { ?>
			<table class="table table-hover table-condensed table-striped">
				<tbody>
					<th>M&eacute;dico</th>
					<th>Fecha y Hora</th>
					<th>Consultorio</th>
					<th class="actions">Acciones</th>
					<?php foreach ($turnos as $turno): ?>
					<tr>
						<td><?php echo $this->Html->link($turno['Medico']['Usuario']['razonsocial'], array('controller' => 'medicos', 'action' => 'view', $turno['Medico']['id_medico'])); ?></td>
						<td><?php echo date( 'd/m/y H:i', strtotime($turno['Turno']['fecha_inicio']) ) . ' - '. date( 'H:i', strtotime( $turno['Turno']['fecha_fin'] ) ); ?>&nbsp;</td>
						<td><?php echo $this->Html->link($turno['Consultorio']['nombre'], array('controller' => 'consultorios', 'action' => 'view', $turno['Consultorio']['id_consultorio'])); ?></td>
						<td class="actions">
							<?php //echo $this->Html->link( 'Notificaciones', array( 'action' => 'edit', $turno['Turno']['id_turno'])); ?>
							<?php echo $this->Form->postLink( 'Cancelar', array( 'action' => 'cancelar', $turno['Turno']['id_turno'] ), null, 'Esta seguro que desea cancelar el turno?' ); ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		<?php } ?>
	
		<h4>Turnos Vencidos</h4>
		<?php if( count( $turnosanteriores ) > 0 ) { ?>
		<table class="table table-hover table-condensed table-striped">
			<tbody>
				<th>M&eacute;dico</th>
				<th>Fecha y Hora</th>
				<th>Consultorio</th>
				<?php foreach ($turnosanteriores as $turno): ?>
				<tr>
					<td><?php echo $this->Html->link($turno['Medico']['Usuario']['razonsocial'], array('controller' => 'medicos', 'action' => 'view', $turno['Medico']['id_medico'])); ?></td>
					<td><?php echo date( 'd/m/y H:i', strtotime($turno['Turno']['fecha_inicio']) ) . ' - '. date( 'H:i', strtotime( $turno['Turno']['fecha_fin'] ) ); ?>&nbsp;</td>
					<td><?php echo $this->Html->link($turno['Consultorio']['nombre'], array('controller' => 'consultorios', 'action' => 'view', $turno['Consultorio']['id_consultorio'])); ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php } else { ?>
			Usted nunca reserv&oacute; un turno posterior al día de hoy.<br /><br />
		<?php } ?>
	</div>
</div>
