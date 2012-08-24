<?php $this->set( 'title_for_layout', "Editar secretaria" ); ?>
<script>
	$( function() {
		$( "a", "#acciones" ).button();
	});
</script>
<div id="acciones">
	<?php echo $this->Form->postLink( 'Eliminar la secretaria', array( 'action' => 'delete', $this->Form->value( 'Secretaria.id_secretaria' ) ), null, 'Esta seguro que desea eliminar esta secretaria?' ); ?>&nbsp;
	<?php echo $this->Html->link( 'Lista de Secretarias', array( 'action' => 'index' ) );?>&nbsp;
	<?php echo $this->Html->link( 'Lista de Usuarios', array( 'controller' => 'usuarios', 'action' => 'index' ) ); ?>&nbsp;
	<?php echo $this->Html->link( 'Lista de Clinicas', array( 'controller' => 'clinicas', 'action' => 'index' ) ); ?>
</div>
<br />
<div class="decorado1">
	<div class="titulo1">Editar una secretaria</div>
	<?php echo $this->Form->create('Secretaria');?>
	<fieldset>
	<?php
		echo $this->Form->input('id_secretaria');
		echo $this->Form->input( 'clinica_id', array( 'between' => '<b>Clinica donde atiende:</b>&nbsp;', 'label' => false ) );
		echo $this->Form->input('resumen', array( 'between' => '<b>Recibir resumen diario</b>&nbsp;', 'label' => false ) );
	?>
	</fieldset>
	<?php echo $this->Form->end( 'Guardar' );?>
</div>