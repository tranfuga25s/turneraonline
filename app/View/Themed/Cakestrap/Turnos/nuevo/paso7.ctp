<fieldset>
    <legend>Su turno se reserv&oacute; correctamente!</legend>
    <table class="table table-hover table-bordered">
        <tbody>
           <th>Avisos</th>
           <th>Acciones</th>
           <tr>
               <td>
                   Usted recibirá un aviso mediante correo electr&oacute;nico a su casilla de correo en caso de los siguientes eventos:<br />
                    &nbsp;&nbsp;-&nbsp;Cancelación de turno.<br />
                    &nbsp;&nbsp;-&nbsp;Turno proximo: <?php echo $tiempo; ?> hora(s) antes.
               </td>
               <td>
                    <div class="btn-group-vertical" style="width: 200px;">
                        <?php echo $this->Html->tag( 'a', 'Cambiar aviso', array( 'onclick' => "$('#cambiahoras').modal();", 'class' => 'btn btn-info' ) ); ?>
                        <?php echo $this->Html->link( 'Cancelar este turno', array( 'controller' => 'turnos', 'action' => 'cancelar', $turno['Turno']['id_turno'] ), array( 'class' => 'btn btn-danger' ) ); ?>
                        <?php echo $this->Html->link( 'Ver todos mis turnos', array( 'controller' => 'turnos', 'action' => 'verTurnos', $usuario['Usuario']['id_usuario'] ), array( 'class' => 'btn btn-success' ) ); ?>
                    </div>
               </td>
           </tr>             
        </tbody>
    </table>
</fieldset>

<div id="cambiahoras" class="modal hide fade"  tabindex="-1" role="dialog" aria-labelledby="reservar" aria-hidden="true">
    <?php echo $this->Form->create( 'Turno', array( 'action' => 'cambiarHorasAviso', 'class' => 'form-inline' ) );
              echo $this->Form->input( 'id_turno', array( 'type' => 'hidden', 'value' => $turno['Turno']['id_turno'] ) ); ?>
    <div class="modal-header">
        <?php echo $this->Form->button( 'x', array( 'class' => "close", 'data-dismiss' => "reservar", 'aria-hidden' => "true" ) ); ?>
        <h3 id="myModalLabel">Cambiar datos del aviso</h3>
    </div>
    <div class="modal-body">
        <p>Ingrese el n&uacute;mero de horas antes que desea recibir el aviso de turno pr&oacute;ximo:</p>
        <?php echo $this->Form->input( 'horas', array( 'type' => 'numeric', 'value' => $tiempo, 'div' => false, 'label' => false, 'after' => ' horas' ) ); ?>       
    </div>
    <div class="modal-footer">
        <?php echo $this->Form->button( 'Cerrar', array( 'class' => 'btn', 'data-dismiss' => 'modal', 'aria-hidden' => true, 'div' => false ) ); ?>
        <?php echo $this->Form->submit( 'Cambiar', array( 'class' => "btn btn-primary", 'div' => false ) ); ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div> 