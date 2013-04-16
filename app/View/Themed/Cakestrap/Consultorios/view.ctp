<?php 
$this->set( 'title_for_layout', "Datos del consultorio" );
?>
<div class="row-fluid">
	
	<?php echo $this->element( 'menu/usuario' ); ?>
	
	<div class="span9 well">
		<h4>Consultorio</h4>
		<dl class="dl">
			<dt>Clinica</dt>
			<dd>
				<?php echo $this->Html->link($consultorio['Clinica']['nombre'], array('controller' => 'clinicas', 'action' => 'view', $consultorio['Clinica']['id_clinica'])); ?>
				&nbsp;
			</dd>
			<dt>Nombre del Consultorio</dt>
			<dd>
				<?php echo h($consultorio['Consultorio']['nombre']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>		
	</div>
</div>
