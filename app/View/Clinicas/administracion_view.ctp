<?php $this->set( 'title_for_layout', "Datos de " . $clinica['Clinica']['nombre'] ); ?>
<h2>Clinica</h2>
<dl>
	<dt><?php echo __('Id Clinica'); ?></dt>
	<dd>
		<?php echo h($clinica['Clinica']['id_clinica']); ?>
		&nbsp;
	</dd>
	<dt><?php echo __('Nombre'); ?></dt>
	<dd>
		<?php echo h($clinica['Clinica']['nombre']); ?>
		&nbsp;
	</dd>
	<dt><?php echo __('Direccion'); ?></dt>
	<dd>
		<?php echo h($clinica['Clinica']['direccion']); ?>
		&nbsp;
	</dd>
	<dt>Tel&eacute;fono</dt>
	<dd>
		<?php echo h($clinica['Clinica']['telefono']); ?>
		&nbsp;
	</dd>
	<dt>Logotipo</dt>
	<dd>
		<?php
		if( !empty( $clinica['Clinica']['logo'] ) ) {
			echo $this->Html->image( $clinica['Clinica']['logo'], array( 'alt' => $clinica['Clinica']['nombre'], 'height' => 150 ) );
		} else {
			echo "No ingreso ningun logotipo";
		} ?>
		&nbsp;
	</dd>
</dl>
<br />
<div class="actions">
	<h2>Acciones</h2>
	<?php echo $this->Html->link( 'Editar esta Clinica', array( 'action' => 'edit', $clinica['Clinica']['id_clinica'] ) ); ?>
	<?php echo $this->Form->postLink( 'Eliminar Clinica', array( 'action' => 'delete', $clinica['Clinica']['id_clinica'] ), null, __('Are you sure you want to delete # %s?', $clinica['Clinica']['id_clinica'] ) ); ?>
	<?php echo $this->Html->link( 'Lista de Clinicas', array( 'action' => 'index' ) ); ?>
	<?php echo $this->Html->link( 'Nueva Clinica', array( 'action' => 'add' ) ); ?>
</div>
