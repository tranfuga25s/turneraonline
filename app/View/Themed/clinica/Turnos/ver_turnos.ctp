<?php $this->set( 'title_for_layout', "Mis turnos" ); ?>

<?php if( count( $turnos ) <= 0 ) { ?>
<div class="turnos index">
	<div class="titulo1">Mis Turnos</div>
	Usted no posee ningun turno pr&oacute;ximo.<br /><br />
<?php } else { ?>
<div class="turnos index">
	<h2>Mis Turnos</h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>M&eacute;dico</th>
			<th>Fecha y Hora</th>
			<th>Consultorio</th>
			<th class="actions">Acciones</th>
	</tr>
	<?php
	//pr( $turnos );
	foreach ($turnos as $turno): ?>
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
	</table>
<?php } ?>
	<h2>Turnos pasados</h2>
<?php if( count( $turnosanteriores ) > 0 ) { ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>M&eacute;dico</th>
			<th>Fecha y Hora</th>
			<th>Consultorio</th>
	</tr>
	<?php
	foreach ($turnosanteriores as $turno): ?>
	<tr>
		<td><?php echo $this->Html->link($turno['Medico']['Usuario']['razonsocial'], array('controller' => 'medicos', 'action' => 'view', $turno['Medico']['id_medico'])); ?></td>
		<td><?php echo date( 'd/m/y H:i', strtotime($turno['Turno']['fecha_inicio']) ) . ' - '. date( 'H:i', strtotime( $turno['Turno']['fecha_fin'] ) ); ?>&nbsp;</td>
		<td><?php echo $this->Html->link($turno['Consultorio']['nombre'], array('controller' => 'consultorios', 'action' => 'view', $turno['Consultorio']['id_consultorio'])); ?></td>
	</tr>
<?php endforeach; ?>
	</table>
<?php } else { ?>
	Usted nunca reserv&oacute; un turno posterior al día de hoy.<br /><br />
<?php } ?>
</div>
<div class="actions">
	<h3>Acciones</h3>
	<ul>
		<li><?php echo $this->Html->link( 'Inicio', '/' ); ?></li>
		<li><?php echo $this->Html->link( 'Pedir nuevo turno', array( 'action' => 'nuevo' ) ); ?></li>
		<li><?php echo $this->Html->link( 'Ver mis datos', array( 'controller' => 'usuarios', 'action' => 'view' ) ); ?></li>
		<li><?php echo $this->Html->link( 'Salir', array( 'controller' => 'usuarios', 'action' => 'salir' ) ); ?></li>
	</ul>
</div>
