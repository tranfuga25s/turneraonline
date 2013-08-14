<?php

$this->set( 'title_for_layout', "Inicio" );
?>

<div class="row-fluid">
    <div class="span12">
        <h3>Panel de control</h3>

        <div class="row-fluid">
            <div class="span2"><?php echo $this->element( 'dashboard/calendario'); ?></div>
            <div class="span5">
                <table class="table table-hover table-bordered">
                    <tbody>
                        <th colspan="4" class="calendario-titulo">Cantidad de turnos para hoy</th>
                        <tr>
                            <td><b>Reservados:</b></td>
                            <td>N</td>

                            <td><b>Libres:</b></td>
                            <td>N</td>
                        </tr>
                        <tr>
                            <td><b>Recibidos:</b></td>
                            <td>N</td>
                            <td><b>Atendidos:</b></td>
                            <td>N</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="row-fluid">
            <div class="thumbnails">
                <?php echo $this->Html->link(
                            $this->Html->tag( 'div',
                                $this->Html->image( 'assets/user_group-icon.gif' ).
                                '<br />Pacientes',
                                array( 'class' => "thumbnail span2 text-center tam-icono-dashboard" )
                            ),
                            array( 'controller' => 'usuarios', 'action' => 'index' ),
                            array( 'escape' => false ) ); ?>
                <?php echo $this->Html->link(
                            $this->Html->tag( 'div',
                                $this->Html->image( 'assets/icon_calendar2.gif' ).
                                '<br />Turnos del día',
                                array( 'class' => "thumbnail span2 text-center tam-icono-dashboard" )
                            ),
                            array( 'controller' => 'medicos', 'action' => 'turnos' ),
                            array( 'escape' => false ) ); ?>
                <?php echo $this->Html->link(
                            $this->Html->tag( 'div',
                                $this->Html->image( 'perfil-generico.jpg' ).
                                '<br />Mi Disponibilidad',
                                array( 'class' => "thumbnail span2 text-center tam-icono-dashboard" )
                            ),
                            array( 'controller' => 'medicos', 'action' => 'disponibilidad' ),
                            array( 'escape' => false ) ); ?>
                <?php echo $this->Html->link(
                            $this->Html->tag( 'div',
                                $this->Html->image( 'assets/medic-icon.png' ).
                                '<br />Mis datos',
                                array( 'class' => "thumbnail span2 text-center tam-icono-dashboard" )
                            ),
                            array( 'controller' => 'usuarios', 'action' => 'view' ),
                            array( 'escape' => false ) ); ?>
                <?php echo $this->Html->link(
                            $this->Html->tag( 'div',
                                $this->Html->image( 'assets/notification-icon.png' ).
                                '<br />Avisos',
                                array( 'class' => "thumbnail span2 text-center tam-icono-dashboard" )
                            ),
                            array( 'controller' => 'avisos', 'action' => 'index' ),
                            array( 'escape' => false ) ); ?>
            </div>
        </div>


    </div>
</div>
