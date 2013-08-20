<?php
$data = $this->requestAction( array( 'controller' => 'turnos', 'action' => 'estadoTurnos'  ) );
?>
<table class="table table-hover table-bordered">
    <tbody>
        <th colspan="4" class="calendario-titulo">Cantidad de turnos para hoy</th>
        <tr>
            <td><b>Reservados:</b></td>
            <td><?php echo $data['reservados']; ?></td>

            <td><b>Libres:</b></td>
            <td><?php echo $data['libres']; ?></td>
        </tr>
        <tr>
            <td><b>Recibidos:</b></td>
            <td><?php echo $data['recibidos']; ?></td>
            <td><b>Atendidos:</b></td>
            <td><?php echo $data['atendidos']; ?></td>
        </tr>
    </tbody>
</table>
