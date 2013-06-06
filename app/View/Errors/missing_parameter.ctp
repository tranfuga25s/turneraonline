<?php $this->set( 'title_for_layout', "No disponible" ); ?>
<h2>Parametros faltantes</h2>
<p class="error">
    La acción no se puede completar porque falta un parámetro: <?php echo $name; ?><br />
    <br />
</p>
<p><a onclick="$('#tecnica').slideDown();">Informaci&oacute;n t&eacute;nica</a></p>
<div style="display: none;" id="tecnica">
    <p class="warning">
    <?php echo $this->element('exception_stack_trace'); ?>
    </p>
</div>
