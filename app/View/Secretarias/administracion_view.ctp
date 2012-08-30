<?php $this->set( 'title_for_layout', "Ver secretaria" ); ?>
<script>
	$( function() {
		$("a","#acciones").button();
	});
</script>
<div id="acciones">
	<?php echo $this->Html->link( 'Editar Secretaria', array( 'action' => 'edit', $secretaria['Secretaria']['id_secretaria'] ) ); ?>&nbsp;
	<?php echo $this->Form->postLink( 'Eliminar Secretaria', array( 'action' => 'delete', $secretaria['Secretaria']['id_secretaria']), null, 'Esta seguro que desea eliminar esta secretaria?' ); ?>&nbsp;
	<?php echo $this->Html->link( 'Lista de Secretarias', array( 'action' => 'index' ) ); ?>&nbsp;
	<?php echo $this->Html->link( 'Lista de Usuarios', array('controller' => 'usuarios', 'action' => 'index' ) ); ?>&nbsp;
	<?php echo $this->Html->link( 'Lista de Clinicas', array('controller' => 'clinicas', 'action' => 'index' ) ); ?> 
</div>
<br />
<div class="decorado1">
<div class="titulo1">Datos de la Secretaria</div>
	<dl>
		<dt><?php echo __('Clinica'); ?></dt>
		<dd>
			<?php echo $this->Html->link($secretaria['Clinica']['nombre'], array('controller' => 'clinicas', 'action' => 'view', $secretaria['Clinica']['id_clinica'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Resumen'); ?></dt>
		<dd>
			<?php
			if(  $secretaria['Secretaria']['resumen'] ) {
				echo "Si";
			} else {
				echo "No";
			} ?>
			&nbsp;
		</dd>
	</dl>
	<br />
<div class="titulo1">Datos de su usuario</div>
	<dl>	
		<dt>Razon Social</dt>
		<dd>
			<?php echo h( $secretaria['Usuario']['razonsocial'] ); ?>
			&nbsp;
		</dd>
		<dt>Email</dt>
		<dd>
			<?php echo $this->Html->link( h( $secretaria['Usuario']['email'] ), 'mailto:'.$secretaria['Usuario']['email'] ); ?>
			&nbsp;
		</dd>
		<dt>Telefono fijo</dt>
		<dd>
			<?php echo h( $secretaria['Usuario']['telefono'] ); ?>
			&nbsp;
		</dd>
		<dt>Telefono celular</dt>
		<dd>
			<?php echo h( $secretaria['Usuario']['celular'] ); ?>
			&nbsp;
		</dd>
		<?php if( count( $secretaria['Usuario']['ObraSocial'] ) != null ) { ?>
		<dt>Obra social</dt>
		<dd>
			<?php echo h( $secretaria['Usuario']['ObraSocial']['nombre'] ); ?>
			&nbsp;
		</dd>
		<?php } ?>
		<dt>Recibir notificaciones</dt>
		<dd>
			<?php if( $secretaria['Usuario']['notificaciones'] ) {
				echo "Si";
			} else {
				echo "No";
			} ?>
			&nbsp;
		</dd>
	</dl>
</div>