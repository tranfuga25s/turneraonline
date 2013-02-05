<h2>Agregar nueva clinica</h2>
<div class="clinicas form">
	<?php echo $this->Form->create('Clinica');?>
	<fieldset>
	<?php
		echo $this->Form->input('nombre', array( 'type' => 'text' ) );
		echo $this->Form->input('direccion');
		echo $this->Form->input('telefono');
		echo $this->Form->input('email');
		
		echo $this->Form->input( 'lat' );
		echo $this->Form->input( 'lng' );
	?>
	</fieldset>
	<?php echo $this->Form->end( 'Agregar' );?>
</div>
<div class="actions">
	<h3>Acciones</h3>
	<ul>
		<li><?php echo $this->Html->link( 'Listado de Clinicas', array( 'action' => 'index' ) ); ?></li>
	</ul>
</div>
