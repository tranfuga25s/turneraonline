<?php $this->set( 'title_for_layout', "Editar grupo" ); ?>
<div id="acciones">
	<?php echo $this->Form->postLink( 'Eliminar', array( 'action' => 'delete', $this->Form->value( 'Grupo.id_grupo' ) ), null, __('Are you sure you want to delete # %s?', $this->Form->value('Grupo.id_grupo'))); ?>
	<?php echo $this->Html->link( 'Lista de Grupos', array( 'action' => 'index' ) );?>	
</div>
<?php echo $this->Form->create('Grupo');?>
<fieldset>
	<legend><h2>Editar un grupo</h2></legend>
	<?php
		echo $this->Form->input('id_grupo');
		echo $this->Form->input('nombre', array( 'type' => 'text' ) );
		echo $this->Form->end( 'Guardar' );
	?>
</fieldset>
