<?php
/**
 * Vista que renderiza la lista de turnos para médicos y/o secretarias
 * Variables utilizadas:
 *  - turnos: Lista de turnos a mostrar
 *  - modelo: controlador a donde redirigirse luego de tener una accion.
 *  - fechas: Fecha a mostrar en la vista
 *  - actualizacion: autoactualizacion activada o no.
 */
 ?>
<!------------------ LISTA DE TURNOS ----------------------------->
<div class="row-fluid">
    
    <div class="span12">
        <table class="table table-condensed table-hover table-striped">
            <tbody>
                <th colspan="4">
                    Turnos para el día <?php echo $fechas; ?>
                    <?php if( $actualizacion == true ) { ?>
                    <span class="pull-right btn btn-success">
                    <?php } else { ?>
                    <span class="pull-right btn btn-inverse">
                    <?php } ?>
                        <?php echo $this->Html->tag('a', 
                                                    '<i class="icon-repeat"></i>',
                                                    array( 'data-toggle' => "modal", 'data-target' => '#autorefresco' )
                                                    ); ?> 
                    </span>
                </th>
                <?php if( count( $turnos ) == 0 ) : ?>
                <tr>
                    <td class="success">No hay turnos para este consultorio</td>
                </tr>
                <?php else : ?>
                <tr>
                    <th>Estado</th>
                    <th>Hora</th>
                    <th>Paciente</th>
                    <th>Acciones</th>
                </tr>
                <?php foreach( $turnos as $turno ) : ?>
                <tr>
                    <td>
                        <?php if( $turno['Turno']['recibido'] == true ) {
                            echo $this->Html->tag( 'a', 'R', array( 'class' => 'badge badge-info' ) );
                        }
                        if( $turno['Turno']['atendido'] == true ) {
                            echo $this->Html->tag( 'a', 'A', array( 'class' => 'badge badge-success' ) );
                        }?>
                    <?php 
                    if( $turno['Turno']['atendido'] == true || $turno['Turno']['cancelado'] == true ) {
                        echo "<td style=\" text-decoration : line-through;\">".date( "H:i", strtotime( $turno['Turno']['fecha_inicio'] ) )."</td>";
                        if( $turno['Turno']['paciente_id'] == null ) {
                            echo "<td>&nbsp;</td>";
                        } else { echo "<td style=\" text-decoration: linethrough;\">".$this->Html->link(  $turno['Paciente']['razonsocial'], array( 'controller' => 'usuarios', 'action' => 'verPorSecretaria', $turno['Paciente']['id_usuario'] ) )."</td>"; }
                    } else {
                        echo "<td>".date( "H:i", strtotime( $turno['Turno']['fecha_inicio'] ) )."</td>";
                        if( $turno['Turno']['paciente_id'] == null ) {
                            echo "<td>&nbsp;</td>";
                        } else {
                             echo "<td>".$this->Html->link(  $turno['Paciente']['razonsocial'], array( 'controller' => 'usuarios', 'action' => 'verPorMedico', $turno['Paciente']['id_usuario'] ) )."</td>";
                        }
                    }
                    ?>
                    <td class="actions" style="text-align: left;">
                        <div class="btn-group">
                        <?php
                            if( $turno['Turno']['paciente_id'] != null ) {
                                if( $turno['Turno']['recibido'] != true ) {
                                      echo $this->Html->link( 'Recibido', array( 'controller' => 'turnos', 'action' => 'recibido', $turno['Turno']['id_turno'], $modelo ), array( 'class' => 'btn btn-mini btn-info' ) );
                                      echo $this->Html->link( 'Atendido', array( 'controller' => 'turnos', 'action' => 'atendido', $turno['Turno']['id_turno'], $modelo ), array( 'class' => 'btn btn-mini btn-success' ) );
                                      echo $this->Html->tag( 'a', 'Cancelar', array( 'onclick' => 'cancelarTurno( '. $turno['Turno']['id_turno'].' )', 'class' => 'btn btn-mini btn-danger' ) );
                                } else if( $turno['Turno']['recibido'] == true && $turno['Turno']['atendido'] == false ) {
                                    echo $this->Html->link( 'Atendido', array( 'controller' => 'turnos', 'action' => 'atendido', $turno['Turno']['id_turno'], $modelo ), array( 'class' => 'btn btn-mini btn-success' ) ); 
                                    echo $this->Html->tag( 'a', 'Cancelar', array( 'onclick' => 'cancelarTurno( '. $turno['Turno']['id_turno'].' )', 'class' => 'btn btn-mini btn-danger' ) );
                                } 
                            } else {
                                if( $turno['Turno']['cancelado'] == false ) {
                                    echo $this->Html->tag( 'a', 'Reservar', array( 'onclick' => 'reservarTurno( '.$turno['Turno']['id_turno'].', '.$turno['Turno']['medico_id'].'  )', 'class' => 'btn btn-mini' ) );
                                    echo $this->Html->tag( 'a', 'Cancelar', array( 'onclick' => 'cancelarTurno( '. $turno['Turno']['id_turno'].' )', 'class' => 'btn btn-mini btn-danger' ) );
                                }
                            }
                            echo $this->Html->tag( 'a', 'Sobre Turno', array( 'onclick' => 'sobreturno( '.$turno['Turno']['medico_id'].
                                                                                                        ', '.$turno['Turno']['id_turno'].
                                                                                                        ', '. date( "H", strtotime( $turno['Turno']['fecha_inicio'] ) ).
                                                                                                        ', '. date( "i", strtotime( $turno['Turno']['fecha_inicio'] ) ) .' )',
                                                                              'class' => 'btn btn-mini btn-warning' ) );
                        ?>
                        </div>
                    </td>       
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>