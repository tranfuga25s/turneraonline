<div class="grupos form">
<?php echo $this->Form->create('Grupo');?>
	<fieldset>
		<legend>Editar un grupo</legend>
	<?php
		echo $this->Form->input('id_grupo');
		echo $this->Form->input('nombre');
	?>
	</fieldset>
<?php echo $this->Form->end( __('Submit') );?>
</div>
<div class="actions">
	<h3>Acciones</h3>
	<ul>

		<li><?php echo $this->Form->postLink( 'Eliminar', array( 'action' => 'delete', $this->Form->value( 'Grupo.id_grupo' ) ), null, __('Are you sure you want to delete # %s?', $this->Form->value('Grupo.id_grupo'))); ?></li>
		<li><?php echo $this->Html->link( 'Lista de Grupos', array( 'action' => 'index' ) );?></li>
	</ul>
</div>
