<?php $this->set( 'title_for_layout', "Datos del usuario" ); ?>
<script>
	$(function() {
		$( "#pestanas" ).tabs();
	});
</script>
<div id="pestanas" class="decorado1">
	<ul>
		<li><a href="#pest-1">Datos personales</a></li>
		<li><a href="#pest-2">Turnos a futuro</a></li>
		<li><a href="#pest-3">Historial de turnos</a></li>
	</ul>
	<div class="usuarios view" id="pest-1">
	<h2>Datos</h2>
		<dl>
			<dt>Email</dt>
			<dd>
				<?php echo h($usuario['Usuario']['email']); ?>
				&nbsp;
			</dd>
			<dt>Nombre completo</dt>
			<dd>
				<?php echo h($usuario['Usuario']['nombre']); ?>
				&nbsp;
			</dd>
			<dt>Apellido</dt>
			<dd>
				<?php echo h($usuario['Usuario']['apellido']); ?>
				&nbsp;
			</dd>
			<dt>Telefono</dt>
			<dd>
				<?php echo h($usuario['Usuario']['telefono']); ?>
				&nbsp;
			</dd>
			<dt>Telefono Celular</dt>
			<dd>
				<?php echo h($usuario['Usuario']['celular']); ?>
				&nbsp;
			</dd>
			<dt>Obra Social</dt>
			<dd>
				<?php echo $this->Html->link( $usuario['ObraSocial']['nombre'], array('controller' => 'obras_sociales', 'action' => 'view', $usuario['ObraSocial']['id_obra_social'])); ?>
				&nbsp;
			</dd>
			<dt>Notificaciones</dt>
			<dd>
				<?php if( $usuario['Usuario']['notificaciones'] ) { ?>
					Habilitadas
				<?php  } else { ?>
					Deshabilitadas
				<?php  }  ?>
				&nbsp;
			</dd>
		</dl>
		<div id="boton">
			<div class="titulo1">Acciones</div>
			<center>
			<?php
				echo $this->Html->link( 'Cambiar Contraseña', array( '/' ) ) . "<br />"; ///@todo Implementar!
				echo $this->Html->link( 'Cambiar email', array( '/' ) ) . "<br />"; ///@todo Implementar!
				echo $this->Html->link( 'Eliminar Usuario', array( 'controller' => 'usuarios', 'action' => 'delete', $usuario['Usuario']['id_usuario'] ) ); 
			?>
			</center>
		</div>
	</div>
	<div id="pest-2">
		<div class="titulo1">Turnos a futuro</div>
		<p>Listado de turnos que este paciente posee reservados</p>
		<?php if( count( $turnos ) <= 0 ) { ?>
			Este paciente no posee ningun turno reservado a futuro.
		<?php } else { ?>
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
					<?php echo $this->Form->postLink( 'Cancelar', array( 'controller' => 'medico', 'action' => 'cancelar', $turno['Turno']['id_turno']), null, 'Esta seguro que desea cancelar el turno?' ); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
		<?php } ?>
	</div>
	<div id="pest-3">
		<div class="titulo1">Historial de turnos</div>
		<p>Listado de turnos en los que este paciente fue atendido en el pasado</p>
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
				<td><?php echo $this->Html->link($turno['Medico']['Usuario']['razonsocial'], array('controller' => 'usuarios', 'action' => 'view', $turno['Medico']['id_medico'])); ?></td>
				<td><?php echo date( 'd/m/y H:i', strtotime($turno['Turno']['fecha_inicio']) ) . ' - '. date( 'H:i', strtotime( $turno['Turno']['fecha_fin'] ) ); ?>&nbsp;</td>
				<td><?php echo $this->Html->link($turno['Consultorio']['nombre'], array('controller' => 'consultorios', 'action' => 'view', $turno['Consultorio']['id_consultorio'])); ?></td>
			</tr>
		<?php endforeach; ?>
			</table>
		<?php } else { ?>
			Este paciente nunca reservó un turno.<br /><br />
		<?php } ?>
	</div>
</div>