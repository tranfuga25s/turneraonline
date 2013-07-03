<!--------------------------------------------------------------------------------------------------------->
<!--------------------------------- CANCELAR UN TURNO ----------------------------------------------------->
<div id="cancelarTurno"  class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="cancelarTurno" aria-hidden="true">
    <?php echo $this->Form->create( 'Turno', array( 'action' => 'cancelar', 'class' => 'form-inline' ) );
          echo $this->Form->input( 'id_turno', array( 'type' => 'hidden', 'value' => -1 ) );
          echo $this->Form->input( 'controlador', array( 'value' => $redirect, 'type' => 'hidden' ) ); ?>
    <div class="modal-header">
        <?php echo $this->Form->button( 'x', array( 'class' => 'close', 'data-dismiss' => 'modal', 'aria-hidden' => "true" ) ); ?>
        <h3>¿Está seguro que desea cancelar este turno?</h3>
    </div>
    <div class="modal-body">
        <p>Por favor, selecci&oacute;ne quien cancela este turno:</p>
        <?php echo $this->Form->radio( 'quien', array( 'p' => 'Paciente', 'm' => 'Médico' ), array( 'legend' => false ) ); ?>
    </div>
    <div class="modal-footer">
        <?php echo $this->Form->button( 'Cancelar Turno', array( 'class' => 'btn btn-danger' ) ); ?>
        <?php echo $this->Form->button( 'No cancelar', array( 'class' => 'btn btn-success', 'onclick' => "actualizar = true;", "data-dismiss" => 'modal' ) ); ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
<?php echo $this->Html->scriptBlock('
function cancelarTurno( id_turno ) {
    actualizar = false;
    $("#TurnoCancelarForm > #TurnoIdTurno").val( id_turno );
    $("#cancelarTurno").modal();
}
');
