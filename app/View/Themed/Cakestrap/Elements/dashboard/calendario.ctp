<?php echo $this->Html->css( 'dashboard' ); ?>
<table border="0" class="table table-bordered">
    <tbody>
        <tr>
            <td colspan="2" class="calendario-titulo"><center>Fecha</center></td>
        </tr>
        <tr>
            <td rowspan="2" class="calendario-dia" style="padding: 25px;"><?php echo date( 'j' ); ?></td>
            <td class="calendario-mes"><center><?php echo date( 'm' ); ?></center></td>
        </tr>
        <tr>
            <td class="calendario-ano"><center><?php echo date( 'Y' ); ?></center></td>
        </tr>
    </tbody>
</table>