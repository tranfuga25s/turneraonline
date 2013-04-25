<?php 
$this->set( 'title_for_layout', "Datos del usuario" ); 
?>
<div class="row-fluid">
	<ul class="nav nav-tabs" id="myTab">
	  <li class="active"><a href="#pest-1" data-toggle="tab">Datos personales</a></li>
	  <li><a href="#pest-2" data-toggle="tab">Turnos a futuro</a></li>
	  <li><a href="#pest-3" data-toggle="tab">Historial de turnos</a></li>
	</ul>
	 
	<div class="tab-content">
	  <div class="tab-pane active" id="pest-1">
		<h2>Datos</h2>
			<table class="table table-hover table-condensed">
			<tbody>
				<tr>
					<td width="25%">Email</td>
					<td><?php echo h($usuario['Usuario']['email']); ?>&nbsp;</td>
				</tr>
				<tr>
					<td>Nombre completo</td>
					<td><?php echo h($usuario['Usuario']['nombre']); ?>&nbsp;</td>
				</tr>
				<tr>
					<td>Apellido</td>
					<td><?php echo h($usuario['Usuario']['apellido']); ?></td>
				</tr>
				<tr>
					<td>Sexo</td>
					<td><?php 
					if( $usuario['Usuario']['sexo'] == 'm' ) {
						echo "Masculino";
					} else {
						echo "Femenino";
					} ?>&nbsp;</td>
				</tr>
				<tr>
					<td>Télefono</td>
					<td><?php echo h($usuario['Usuario']['telefono']); ?></td>
				</tr>
				<tr>
					<td>Teléfono Celular</td>
					<td><?php echo h($usuario['Usuario']['celular']); ?></td>
				</tr>
				<tr>
					<td>Obra Social</td>
					<td>
					<?php
					if( $usuario['Usuario']['obra_social_id'] != null ) { 
						echo $this->Html->link( $usuario['ObraSocial']['nombre'], array( 'controller' => 'obras_sociales', 'action' => 'view', $usuario['ObraSocial']['id_obra_social'] ) );
					} else {
						echo "Ninguna";
					} ?>						
					</td>
				</tr>
				<tr>
					<td>Notificaciones</td>
					<td><?php if( $usuario['Usuario']['notificaciones'] ) { ?>
							<span class=" icon-ok-sign"></span>Habilitadas
						<?php  } else { ?>
							<span class="icon-ban-circle"></span>Deshabilitadas
						<?php  }  ?></td>
				</tr>
				
			</tbody>
		</table>
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
	  <div class="tab-pane" id="pest-2">
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
	  <div class="tab-pane" id="pest-3">
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
</div> 
<script>
  $(function () {
    $('#myTab a:first').tab('show');
  })
</script>
