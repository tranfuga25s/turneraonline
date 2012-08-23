<div class="usuarios form">
<?php echo $this->Form->create('Usuario');?>
	<fieldset>
		<legend>Editar un usuario</legend>
	<?php
		echo $this->Form->input('id_usuario');
		echo $this->Form->input('email');
		echo $this->Form->input('nombre');
		echo $this->Form->input('apellido');
		echo $this->Form->input('telefono');
		echo $this->Form->input('celular');
		echo $this->Form->input('obra_social_id', array( 'options' => $obras_sociales ) );
		echo $this->Form->input('notificaciones');
		echo $this->Form->input('grupo_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink( 'Eliminar Usuario', array('action' => 'delete', $this->Form->value('Usuario.id_usuario')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Usuario.id_usuario'))); ?></li>
		<li><?php echo $this->Html->link( 'Lista de Usuarios', array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link( 'Lista de Grupos', array('controller' => 'grupos', 'action' => 'index')); ?> </li>
	</ul>
</div>
