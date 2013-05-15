<div id="acciones">
    <?php echo $this->Html->link( 'Lista de Secretarias', array('action' => 'index'));
          echo $this->Html->link( 'Lista de Usuarios', array('controller' => 'usuarios', 'action' => 'index'));
          echo $this->Html->link( 'Nuevo Usuario', array('controller' => 'usuarios', 'action' => 'add'));
          echo $this->Html->link( 'Lista de Clinicas', array('controller' => 'clinicas', 'action' => 'index')); ?>    
</div>
<div class="secretarias form">
<?php echo $this->Form->create('Secretaria');?>
	<fieldset>
		<legend><h2>Agregar nueva secretaria</h2></legend>
		<p>Recuerde que para habilitar una secretaria, el usuario a habilitar debe de estar perteneciendo al grupo secretarias.</p>
	<?php
		echo $this->Form->input('usuario_id', array( 'label' => 'Usuario a convertir:'));
		echo $this->Form->input('clinica_id', array( 'label' => 'Clínica:' ) );
		echo $this->Form->input('resumen', array( 'label' => 'Enviar resumen diario a su email con los turnos del día'));
	?>
	</fieldset>
    <?php echo $this->Form->end( 'Agregar' );?>
</div>