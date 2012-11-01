<h2>Especialidad</h2>
<dl>
	<dt><?php echo __('Id Especialidad'); ?></dt>
	<dd>
		<?php echo h($especialidade['Especialidad']['id_especialidad']); ?>
		&nbsp;
	</dd>
	<dt><?php echo __('Nombre'); ?></dt>
	<dd>
		<?php echo h($especialidade['Especialidad']['nombre']); ?>
		&nbsp;
	</dd>
</dl>
<br />
<div class="actions">
	<h2>Acciones</h2>
	<?php echo $this->Html->link( 'Editar esta especialidad', array( 'action' => 'edit', $especialidade['Especialidad']['id_especialidad'] ) ); ?>
	<?php echo $this->Form->postLink( 'Eliminar esta Especialidad', array( 'action' => 'delete', $especialidade['Especialidad']['id_especialidad']), null, 'Esta seguro que desea eliminar esta especialidad?' ); ?>
	<?php echo $this->Html->link( 'Lista de Especialidades', array( 'action' => 'index' ) ); ?>
	<?php echo $this->Html->link( 'Nueva Especialidaded', array( 'action' => 'add' ) ); ?>
</div>
