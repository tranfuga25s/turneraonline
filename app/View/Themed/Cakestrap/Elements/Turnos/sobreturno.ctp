
<!---------------------------------------------------------------------------------------------------------->
<!---------------------------------- SOBRETURNO ------------------------------------------------------------>
<div id="sobreturno" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="sobreturno" aria-hidden="true">
    <?php echo $this->Form->create( 'Turno', array( 'action' => 'sobreturno', 'class' => 'form-inline' ) );
          echo $this->Form->input ( 'id_medico', array( 'type' => 'hidden', 'value' => 0 ) );
          echo $this->Form->input ( 'id_turno', array( 'type' => 'hidden', 'value' => 0 ) );
          echo $this->Form->input( 'controlador', array( 'value' => $controller, 'type' => 'hidden' ) ); ?>
    <div class="modal-header">
        <?php echo $this->Form->button( 'x', array( 'class' => 'close', 'data-dismiss' => 'modal', 'aria-hidden' => "true" ) ); ?>
        <h3>Agregar sobreturno</h3>
    </div>
    <div class="modal-body">
        Ingrese el paciente al cual desea reservar el sobreturno:
        <?php echo $this->Form->input( 'spaciente', array( 'label' => 'Paciente:', 'class' => 'input-xlarge', 'autocomplete' => 'off' ) ); ?>
        <?php echo $this->Form->input( 'hora', array( 'class' => 'input-mini', 'label' => 'Horario de inicio:', 'div' => false ) ); ?>
        <?php echo $this->Form->input( 'min', array( 'class' => 'input-mini', 'label' => false, 'before' => ':', 'div' => false ) ); ?>
        <?php echo $this->Form->input( 'duracion', array( 'label' => 'Duración', 'after' => 'minutos', 'class' => 'input-mini', 'value' => 10 ) ); ?>
    </div>
    <div class="modal-footer">
        <?php echo $this->Form->button( 'Reservar', array( 'class' => 'btn btn-success', 'onclick' => "function() { if( $(\"#MedicoSpaciente\").val() == '' ) { alert( 'Por favor, ingrese un paciente para generar el sobreturno' ); } else { $(\"#MedicoSobreturnoForm\").submit();" ) ); ?>
        <?php echo $this->Form->button( "Cancelar", array( 'class' => 'btn btn-inverse', 'data-dismiss' => 'modal', 'aria-hidden' => "true" ) ); ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
</td>
<?php echo $this->Html->scriptBlock('
function sobreturno( medico, turno, hora, min ) {
 actualizar = false;
 // Seteo los datos necesarios
 $("#TurnoSpaciente").typeahead({
    source: '.$this->requestAction(  array( 'controller' => 'usuarios', 'action' => 'pacientes.json' ) ).',
    items: 4 // Cantidad de elementos a mostrar en el dialogo
  });

 $("#TurnoIdTurno").attr( "value", turno  ).appendTo("#TurnoSobreturnoForm");
 $("#TurnoIdMedico").attr( "value", medico ).appendTo("#TurnoSobreturnoForm");

 $("#TurnoMin").val( min );
 $("#TurnoHora").val( hora );

 $("#sobreturno").modal();
}
'); ?>
