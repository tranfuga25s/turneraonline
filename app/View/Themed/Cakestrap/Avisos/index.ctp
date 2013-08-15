<?php
$this->set( 'title_for_layout', "Avisos" );
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
                    Los avisos por email se envían <span class="badge badge-info">NN</span> horas antes del turno.
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
</div>
