<?php

$this->set( 'title_for_layout', "Inicio" );
?>

<div class="row-fluid">
    <div class="span12">
        <h3>Panel de control</h3>
        
        <div class="row-fluid">
            <div class="span2"><?php echo $this->element( 'dashboard/calendario'); ?></div>
            <div class="span9">
                <h4>Estado</h4>
                <table class="table table-hover table-bordered">
                    <tbody>
                        <th colspan="8">Cantidad de turnos para hoy</th>
                        <tr>
                            <td><b>Atendidos:</b></td>
                            <td>N</td>
                            <td><b>Reservados:</b></td>
                            <td>N</td>
                            <td><b>Recibidos:</b></td>
                            <td> N</td>
                            <td><b>Libres:</b></td>
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
                                $this->Html->image( 'assets/icons/16_48x48.png' ).
                                '<br />Pacientes',
                                array( 'class' => "thumbnail span2 text-center" )
                            ),
                            array( 'controller' => 'usuarios', 'action' => 'index' ),
                            array( 'escape' => false ) ); ?>
                <?php echo $this->Html->link( 
                            $this->Html->tag( 'div',
                                $this->Html->image( 'assets/icon_calendar2.gif' ).
                                '<br />Turnos del día',
                                array( 'class' => "thumbnail span2 text-center" )
                            ),
                            array( 'controller' => 'medicos', 'action' => 'turnos' ),
                            array( 'escape' => false ) ); ?>                
                <div class="thumbnail span2">
                    <?php echo $this->Html->link( 'Mi Disponibilidad', '#' ); ?>
                </div>
                
                <div class="thumbnail span2">
                    <?php echo $this->Html->link( 'Mis Datos', '#' ); ?>
                </div>
                
                <div class="thumbnail span2">
                    <?php echo $this->Html->link( 'Avisos', '#' ); ?>
                </div>
            </div>
        </div>
        
        
    </div>
</div>
