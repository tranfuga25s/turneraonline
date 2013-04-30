<?php
$this->set( 'title_for_layout', "Configurar avisos por email" );
?>
<div id="acciones">
	<?php echo $this->Html->link( 'Volver', array( 'action' => 'cpanel' ) ); ?>
</div>
<br />
<div class="index">
	<h2>Avisos generados por email</h2>
	<?php foreach( $avisos as $aviso ) : ?>
	<fieldset>
		<legend><h3><?php echo $aviso['nombre']; ?></h3></legend>
		<p><?php echo $aviso['explicacion']; ?></p>
		<p>A continuación se encuentra el texto para cada uno de los avisos en su formato correspondiente:</p>
		<?php foreach( $aviso['Formato'] as $formato ) : ?>
			<?php echo $this->Form->create( 'Aviso' ); ?>
			<fieldset>
				<legend><h4><?php echo $formato['nombre']; ?></h4></legend>
				<p><?php echo $formato['campos']; ?></p>
				<?php echo $this->Form->input( 'content', array( 'type' => 'textarea', 'value' => $formato['content'], 'label' => false ) ); ?>
				<?php echo $this->Form->button( 'Guardar Formato' ); ?>
			</fieldset>
			<?php echo $this->Form->end(); ?>
		<?php endforeach; ?>
	</fieldset>
	<?php endforeach; ?>
</div>
