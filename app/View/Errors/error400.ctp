<?php $this->set( 'title_for_layout', "Recurso no encontrado" ); ?>
<h1>Ups! No está!</h1>
<h2><?php echo $name; ?></h2>
El recurso que est&aacute; intentando acceder no se encuentra disponible.<br />
Intenteló mas tarde o contactes&eacite; con el soporte t&eacute;cnico.
<p><a onclick="$('#tecnico').slideDown()">Informaci&oacute; t&eacute;nica</a></p>
<div style="display: none;" id="tecnica">
<p class="error">
	<strong><?php echo __d('cake', 'Error'); ?>: </strong>
	<?php printf(
		__d('cake', 'The requested address %s was not found on this server.'),
		"<strong>'{$url}'</strong>"
	); ?>
</p>
<?php
if (Configure::read('debug') > 0 ):
	echo $this->element('exception_stack_trace');
endif;
?>
</div>