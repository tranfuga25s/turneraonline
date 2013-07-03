<?php
/**
 * Dialogo para reservar turnos
 * Utiliza los siguientes parametros
 * $modelo Define el modelo para el formulario
 */
?>
<!------------------------------------------------------------->
<!------------------ RESERVAR TURNO --------------------------->
<div id="reservar" class="modal hide fade"  tabindex="-1" role="dialog" aria-labelledby="reservar" aria-hidden="true">
    <?php echo $this->Form->create( 'Turno', array( 'action' => 'reservarTurno', 'class' => 'form-inline' ) );
          echo $this->Form->input( 'id_medico', array( 'type' => 'hidden', 'value' => 0 ) );
          echo $this->Form->input( 'id_turno', array( 'type' => 'hidden', 'value' => 0 ) );
          echo $this->Form->input( 'controlador', array( 'value' => $redirect, 'type' => 'hidden' ) ); ?>
    <div class="modal-header">
        <?php echo $this->Form->button( 'x', array( 'class' => "close", 'data-dismiss' => "reservar", 'aria-hidden' => "true" ) ); ?>
        <h3 id="myModalLabel">Reservar turno</h3>
    </div>
    <div class="modal-body">
        <p>Ingrese el paciente al cual desea reservar el turno:</p>
        <?php echo $this->Form->input( 'rpaciente', array( 'label' => 'Paciente', 'div' => false, 'autocomplete' => 'off' ) ); ?>
    </div>
    <div class="modal-footer">
        <?php echo $this->Form->button( 'Cerrar', array( 'class' => 'btn', 'data-dismiss' => 'modal', 'aria-hidden' => true, 'div' => false ) ); ?>
        <?php echo $this->Form->submit( 'Reservar', array( 'class' => "btn btn-primary", 'div' => false ) ); ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
<?php echo $this->Html->scriptBlock('
function reservarTurno( turno, medico ) {
  actualizar = false;
    // Pongo los datos en el formulario
  $("#TurnoReservarTurnoForm > #TurnoIdTurno").val( turno );
  $("#TurnoReservarTurnoForm > #TurnoIdMedico").val( medico );
  $("#TurnoRpaciente").typeahead({
    source: '.$this->requestAction(  array( 'controller' => 'usuarios', 'action' => 'pacientes.json' ) ).',
    items: 4 // Cantidad de elementos a mostrar en el dialogo
  });

  $("#reservar").modal();
}
'); ?>
