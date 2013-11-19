<?php
$data = $this->requestAction( array( 'controller' => 'turnos', 'action' => 'estadoTurnos' ) );

?>

<ul class="nav nav-tabs" id="tabConsultorios">
    <?php foreach( $consultorios as $consultorio ) : ?>
    <li><a href="#consultorio<?php echo $consultorio['Consultorio']['id_consultorio']; ?>"><?php $consultorio['Consultorio']['nombre']; ?></a></li>
    <?php endforeach; ?>
</ul>

<div class="tab-content">
    <?php foreach( $consultorios as $consultorio ) :

    $sumatoria = intval( $data['reservados'] ) + intval( $data['libres'] ) + intval( $data['recibidos'] ) + intval( $data['atendidos'] );
    if( $sumatoria == 0 ) {
        $porcentajes = array( 'reservados' => 0, 'libres' => 0, 'recibidos' => 0, 'atendidos' => 0 );
    } else {
        $porcentajes = array(
            'reservados' => ( intval( $data['reservados'] ) * 100 ) / $sumatoria,
            'libres'     => ( intval( $data['libres']     ) * 100 ) / $sumatoria,
            'recibidos'  => ( intval( $data['recibidos']  ) * 100 ) / $sumatoria,
            'atendidos'  => ( intval( $data['atendidos']  ) * 100 ) / $sumatoria
        );
    }
    ?>
    <div class="tab-pane" id="consultorio<?php echo $consultorio['Consultorio']['id_consultorio']; ?>">
        <table class="table table-hover table-bordered">
            <tbody>
                <th colspan="4" class="calendario-titulo">Cantidad de turnos para hoy</th>
                <tr>
                    <td><b>Reservados:</b></td>
                    <td><span class="label label-info"><?php echo $data['reservados']; ?></span></td>

                    <td><b>Libres:</b></td>
                    <td><span class="label"><?php echo $data['libres']; ?></span></td>
                </tr>
                <tr>
                    <td><b>Recibidos:</b></td>
                    <td><span class="label label-warning"><?php echo $data['recibidos']; ?></span></td>
                    <td><b>Atendidos:</b></td>
                    <td><span class="label label-success"><?php echo $data['atendidos']; ?></span></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="progress progress-striped active" style="margin-bottom: 2px;">
                            <div class="bar bar-success" style="width: <?=$porcentajes['atendidos']?>%;"></div>
                            <div class="bar bar-warning" style="width: <?=$porcentajes['recibidos']?>%;"></div>
                            <div class="bar bar-info" style="width: <?=$porcentajes['reservados']?>%;"></div>
                            <div class="bar" style="width: <?=$porcentajes['libres']?>%;"></div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php endforeach; ?>
</div>
