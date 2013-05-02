<?php $this->set( 'title_for_layot', "Modificar datos de obra social" ); ?>
<div id="acciones">
		<?php echo $this->Form->postLink( 'Eliminar', array( 'action' => 'delete', $this->Form->value('ObraSocial.id_obra_social')), null, 'Esta seguro que desea eliminar esta obra social?' ); ?>
		<?php echo $this->Html->link( 'Lista de Obras Sociales', array( 'action' => 'index' ) ); ?>	
</div>
<br />
<?php echo $this->Form->create('ObraSocial');?>
<fieldset>
	<legend><h2>Editar obra social</h2></legend>
<?php
	echo $this->Form->input('id_obra_social');
	echo $this->Form->input('nombre');
	echo $this->Form->input('direccion');
	echo $this->Form->input('telefono');
	if( $this->request->data['ObraSocial']['logo'] != '' ) {
		echo $this->Html->image( $this->request->data['ObraSocial']['logo'] );
	}
	echo $this->Form->input('logo', array( 'type' => 'file', 'label' => 'Cambiar logo:' ) );
?>
</fieldset>
<?php echo $this->Form->end( 'Guardar cambios'); ?>
