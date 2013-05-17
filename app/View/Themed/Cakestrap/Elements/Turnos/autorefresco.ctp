<!----------------------------------------------------------->
<!------------------ AUTOREFRESCO --------------------------->
<div id="autorefresco" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="autorefresco" aria-hidden="true">
    <?php echo $this->Form->create( 'Medicos', array( 'action' => 'autoactualizacion', 'class' => 'form-inline' ) ); ?>
    <div class="modal-header">
        <?php echo $this->Form->button( 'x', array( 'class' => 'close', 'data-dismiss' => 'autorefresco', 'aria-hidden' => "true" ) ); ?>
        <h3>Autorefresco de pantalla</h3>
    </div>
    <div class="modal-body">
        Seleccione la opci&oacute;n de habilitacion de autorefresco
        <?php echo $this->Form->input( 'actualizacion', array( 'type' => 'hidden', 'value' => $actualizacion ) ); ?>
    </div>
    <div class="modal-footer">
        <?php echo $this->Form->button( 'Habilitado', array( 'class' => 'btn btn-success', 'onclick' => "$('#MedicosActualizacion').val( true );" ) ); ?>
        <?php echo $this->Form->button( 'Deshabilitado', array( 'class' => 'btn btn-danger', 'onclick' => "$('#MedicosActualizacion').val( false );" ) ); ?></div>
    <?php echo $this->Form->end(); ?>
</div>

<?php echo $this->Js->buffer('
$( function() { 
    if( actualizar ) {
        // No uso el reload porque si existen parametros los intentará enviar haciendo que aparezcan carteles
        $.doTimeout( 2*60*1000, function() {  if( actualizar ) { location.replace( \''.Router::url( array( 'action' => "turnos" ) ).'\' ); }   });
    }
});
'); 
echo $this->Html->script( 'dotimeout.min', array( 'inline' => false ) );
?>