<?php $this->set( 'title_for_layout', "No disponible" ); ?>
<h2>Error de conexión a la base de datos de clientes</h2>
<p class="error">
	Existi&oacute; un error al intentar conectarse al sistema de base de datos de clientes.<br />
	Es probable que no se encuentre disponible momentaneamente.<br /><br />
	<br />
</p>
<p><a onclick="$('#tecnica').slideDown();">Informaci&oacute;n t&eacute;nica</a></p>
<div style="display: none;" id="tecnica">
	<p class="warning">
	<?php
		if (isset($message)):
			echo 'The database server returned this error: '.$message;
		endif;
		echo $this->element('exception_stack_trace');
	?>	
	</p>
</div>