<?php $this->set( 'title_for_layout', "Datos de obra social" ); ?>
<div id="acciones">
	<?php echo $this->Html->link( 'Editar esta Obra Social', array('action' => 'edit', $obrasSociale['ObraSocial']['id_obra_social'])); ?>&nbsp;
	<?php echo $this->Form->postLink( 'Eliminar esta Obra Social', array('action' => 'delete', $obrasSociale['ObraSocial']['id_obra_social']), null, __('Are you sure you want to delete # %s?', $obrasSociale['ObraSocial']['id_obra_social'])); ?>&nbsp;
	<?php echo $this->Html->link( 'Lista de Obras Sociales', array('action' => 'index')); ?>&nbsp;
	<?php echo $this->Html->link( 'Nueva Obra Social', array( 'action' => 'add' ) ); ?>
</div>
<br />
<h2>Obra Social</h2>
<dl>
	<dt>C&oacute;digo de obra social:</dt>
	<dd>
		<?php echo h($obrasSociale['ObraSocial']['id_obra_social']); ?>
		&nbsp;
	</dd>
	<dt>Nombre:</dt>
	<dd>
		<?php echo h($obrasSociale['ObraSocial']['nombre']); ?>
		&nbsp;
	</dd>
	<dt>Direcci&oacute;n</dt>
	<dd>
		<?php echo h($obrasSociale['ObraSocial']['direccion']); ?>
		&nbsp;
	</dd>
	<dt>Tel&eacute;fono</dt>
	<dd>
		<?php echo h($obrasSociale['ObraSocial']['telefono']); ?>
		&nbsp;
	</dd>
	<dt>Logotipo:</dt>
	<dd>
		<?php
		if( isset( $obrasSociale['ObraSocial']['logo'] ) ) { 
			echo $this->Html->image( $obrasSociale['ObraSocial']['logo'], array( 'height' => 100, 'width' => 100 ) );
		} ?>
		&nbsp;
	</dd>
</dl>