<?php
$this->set( 'title_for_layout', "Avisos" );
$this->Html->script( 'bootstrap-limit.min', array( 'inline' => false, 'plugin' => false ) );
?>
<div class="row-fluid">

    <div class="navbar">
        <div class="navbar-inner">
            <ul class="nav">
                <li><?php echo $this->Html->link( 'Inicio', array( 'controller' => 'usuarios', 'action' => 'dashboard' ) ); ?></li>
                <li><?php echo $this->Html->link( 'Pacientes', array( 'controller' => 'usuarios', 'action' => 'index' ) ); ?></li>
                <li><?php echo $this->Html->link( 'Turnos del día', array( 'controller' => 'turnos', 'action' => 'medico' ) ); ?></li>
                <li><?php echo $this->Html->link( 'Salir', array( 'controller' => 'usuarios', 'action' => 'salir' ) ); ?></li>
            </ul>
        </div>
    </div>

</div>

<div class="row-fluid">
    <div class="span6">
        <h3>Sistema de Avisos</h3>
        <div class="tabbable tabs-left">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#email" data-toggle="tab">Email</a></li>
                <li><a href="#sms" data-toggle="tab">SMS</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="email">
                    Usted posee <span class="badge badge-success">habilitado</span> los avisos por email.<br />
                    Los avisos por email se envían <span class="badge badge-info"><?php echo $horas_email; ?></span> horas antes del turno.
                </div>
                <div class="tab-pane" id="sms">
                    Usted posee
                    <?php if( $sms_habilitado ) : ?>
                    <span class="badge badge-success">habilitado</span>
                    <?php else : ?>
                    <span class="badge badge-error">deshabilitado</span>
                    <?php endif; ?>
                    los avisos por sms.<br />
                    <?php if( $sms_habilitado ) : ?>
                    Los avisos por email se envían <span class="badge badge-info"><?php echo $minutos_sms; ?></span> minutos antes del turno.
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="span4">
        <h4>Estado del sistema en el mes xxxx</h4>
        <table class="table table-bordered table-striped table-hover">
            <tbody>
                <tr>
                    <th rowspan="2">Item</th>
                    <th colspan="3">Estado</th>
                </tr>
                <tr>
                    <th>Enviados</th>
                    <th>Recibidos</th>
                    <th>Costo</th>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>N</td>
                    <td>&nbsp;</td>
                    <td><span class="badge badge-success">Gratis!</span></td>
                </tr>
            <?php if( $sms_habilitado ) : ?>
                <tr>
                    <td>Sms</td>
                    <td><?php echo $estado_sms['enviados']; ?></td>
                    <td><?php echo $estado_sms['recibidos']; ?></td>
                    <td><?php echo $this->Number->currency( $estado_sms['costo'] ); ?></td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if( $sms_habilitado ) : ?>
    <div class="span12">
        <h4>Ultimos Sms recibidos</h4>
        <div class="btn-group">
        <?php echo $this->Html->tag( 'a', $this->Html->tag( 'span', '', array( 'class' => 'icon icon-comment') ).' Enviar SMS',
                                     array( 'class' => 'btn btn-success',
                                            'onclick' => "responderMensaje(0,'');" )
              ); ?></div><br /><br />
        <table class="table table-bordered table-striped">
            <tbody>
                <th>Teléfono</th>
                <th>Fecha y hora</th>
                <th>Mensaje</th>
                <th>Paciente</th>
                <th>Acciones</th>
                <?php foreach( $mensajes as $mensaje ): ?>
                <tr>
                    <td><?php echo h( $mensaje['Sms']['uid'] ); ?></td>
                    <td><?php echo h( $mensaje['Sms']['fechahora'] ); ?></td>
                    <td><?php echo h( utf8_encode( $mensaje['Sms']['texto'] ) ); ?></td>
                    <td><?php if( array_key_exists( 'Paciente', $mensaje ) ) {
                        echo $this->Html->link( h( $mensaje['Paciente']['razonsocial'] ),
                                                      array( 'controller' => 'usuarios', 'action' => 'view', $mensaje['Paciente']['id_usuario'] ) );
                        } else { echo "Desconocido"; } ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <?php echo $this->Html->tag( 'a',
                                                $this->Html->tag( 'span', '', array( 'class' => 'icon icon-comment') ).' Responder',
                                                array( 'class' => 'btn btn-success',
                                                       'onclick' => 'responderMensaje('.$mensaje['Sms']['tid'].",".$mensaje['Sms']['uid'].");" ) ); ?>
                            <?php echo $this->Form->postLink( $this->Html->tag( 'span', '', array( 'class' => 'icon icon-trash') ).' Eliminar',
                                                              array( 'action' => 'eliminar', $mensaje['Sms']['tid'] ),
                                                              array( 'class' => 'btn btn-danger', 'escape' => false ),
                                                              'Esta seguro que desea eliminar este mensaje de texto?' ); ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="responder" class="modal hide fade"  tabindex="-1" role="dialog" aria-labelledby="responder" aria-hidden="true">
        <?php echo $this->Form->create( 'Aviso', array( 'action' => 'enviarSms', 'class' => 'form-inline' ) );
              echo $this->Form->input( 'tid', array( 'type' => 'hidden', 'value' => null ) ); ?>
        <div class="modal-header">
            <?php echo $this->Form->button( 'x', array( 'class' => "close", 'data-dismiss' => "responder", 'aria-hidden' => "true" ) ); ?>
            <h3 id="myModalLabel">Responder mensaje</h3>
        </div>
        <div class="modal-body">
            <?php echo $this->Form->input( 'numero', array( 'label' => 'Número de teléfono:',
                                                            'div' => false,
                                                            'required' => true ) ); ?>
            <p>Ingrese el texto que desea enviar:</p>
            <?php echo $this->Form->input( 'texto', array( 'type' => 'textarea',
                                                           'label' => false,
                                                           'div' => false,
                                                           'rows' => 4,
                                                           'cols' => 50,
                                                           'maxLenght' => 140,
                                                           'required' => true ) );
                  echo $this->Html->tag( 'span',
                                         'Quedan '.
                                          $this->Html->tag( 'span', '140', array( 'class' => 'badge', 'id' => "AvisoContador" ) ).
                                         ' caraceteres',
                                         array( 'escape' => false ) );
            ?>
        </div>
        <div class="modal-footer">
            <?php echo $this->Form->button( 'Cerrar', array( 'class' => 'btn', 'data-dismiss' => 'modal', 'aria-hidden' => true, 'div' => false ) ); ?>
            <?php echo $this->Form->submit( 'Enviar', array( 'class' => "btn btn-primary", 'div' => false ) ); ?>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
    <?php echo $this->Html->scriptBlock('
    function responderMensaje( tid, numero ) {
        // Pongo los datos en el formulario
        if( tid == 0 ) {
            $("#myModalLabel").html("Enviar Sms" );
        }
        $("#AvisoTid").val( tid );
        $("#AvisoNumero").val( numero );
        $("#responder").modal();
    }
    ');
    echo $this->Js->buffer('
    $("#AvisoTexto").limit( {maxLength: 140, counter: $("#AvisoContador") });
    ');
    endif; ?>
</div>
