<?php $this->set( 'title_for_layout', "Editar medico" ); ?>
<script>
	$( function() { $("a", "#accion" ).button(); } );
</script>
<div id="accion">
	<?php echo $this->Html->link( 'Lista de Medicos', array('action' => 'index'));
		  echo $this->Html->link( 'Modificar datos de usuario', array( 'controller' => 'usuarios', 'action' => 'edit', $this->data['Medico']['usuario_id'] ) );
		  echo $this->Html->link( 'Modificar Disponibilidad', array( 'action' => 'disponibilidad' ) );
		  echo $this->Html->link( 'Dar de baja como medico', array( 'action' => 'darBaja', $this->data['Medico']['id_medico'] ) ); ?>
</div>
<br />
<div class="decorado1">
	<?php echo $this->Form->create('Medico');?>
	<div class="titulo1">Editar los datos de un m&eacute;dico</div>
	<fieldset>
	<?php
		echo $this->Form->input( 'id_medico' );
		echo $this->Form->input( 'clinica_id' );
		echo $this->Form->input( 'especialidad_id', array( 'options' => $especialidades ) );
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>