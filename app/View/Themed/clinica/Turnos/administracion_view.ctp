<div class="turnos view">
<h2><?php  echo __('Turno');?></h2>
	<dl>
		<dt><?php echo __('Id Turno'); ?></dt>
		<dd>
			<?php echo h($turno['Turno']['id_turno']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Paciente'); ?></dt>
		<dd>
			<?php echo $this->Html->link($turno['Paciente']['razonsocial'], array('controller' => 'usuarios', 'action' => 'view', $turno['Paciente']['id_usuario'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Medico'); ?></dt>
		<dd>
			<?php echo $this->Html->link($turno['Medico']['Usuario']['razonsocial'], array('controller' => 'medicos', 'action' => 'view', $turno['Medico']['id_medico'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Inicio'); ?></dt>
		<dd>
			<?php echo h($turno['Turno']['fecha_inicio']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Fin'); ?></dt>
		<dd>
			<?php echo h($turno['Turno']['fecha_fin']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Consultorio'); ?></dt>
		<dd>
			<?php echo $this->Html->link($turno['Consultorio']['nombre'], array('controller' => 'consultorios', 'action' => 'view', $turno['Consultorio']['id_consultorio'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Recibido'); ?></dt>
		<dd>
			<?php if( $turno['Turno']['recibido'] ) { ?>
			Si&nbsp;
			<?php } else { ?>
			No&nbsp;
			<?php } ?>
		</dd>
		<dt><?php echo __('Atendido'); ?></dt>
		<dd>
			<?php if( $turno['Turno']['atendido'] ) { ?>
			Si&nbsp;
			<?php } else { ?>
			No&nbsp;
			<?php } ?>
		</dd>
		<dt><?php echo __('Cancelado'); ?></dt>
		<dd>
			<?php if( $turno['Turno']['cancelado'] ) { ?>
			Si&nbsp;
			<?php } else { ?>
			No&nbsp;
			<?php } ?>
		</dd>
	</dl>
</div>
<div class="actions">
	<h3>Acciones</h3>
	<ul>
		<li><?php echo $this->Html->link( 'Editar Turno', array('action' => 'edit', $turno['Turno']['id_turno'])); ?> </li>
		<li><?php echo $this->Form->postLink( 'Eliminar Turno', array('action' => 'delete', $turno['Turno']['id_turno']), null, __('Are you sure you want to delete # %s?', $turno['Turno']['id_turno'])); ?> </li>
		<li><?php echo $this->Html->link( 'Lista de Turnos', array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link( 'Nuevo Turno', array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link( 'Lista de Usuarios', array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link( 'Lista de Consultorios', array('controller' => 'consultorios', 'action' => 'index')); ?> </li>
	</ul>
</div>
