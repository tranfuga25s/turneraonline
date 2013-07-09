<?php
$this->set( 'title_for_layout', "Configuración de envio de sms" );

?>
<div id="acciones">
    <?php echo $this->Html->link( 'Volver', array( 'action' => 'cpanel' ) ); ?>
</div>
<br />
<div style="width: 48%; float: left;">
    <fieldset>
        <legend><h2>Credito Disponible</h2></legend>
        <table>
            <tbody>
                <th>&nbsp;</th>
                <th>Cantidad</th>
                <tr>
                    <td>Mensajes para enviar:</td>
                    <td><?php echo $saldo['salida']; ?> mensajes</td>
                </tr>
                <tr>
                    <td>Mensajes a recibir:</td>
                    <td><?php echo $saldo['entrada']; ?> mensajes</td>
                </tr>
            </tbody>
        </table>
    </fieldset>
</div>

<div style="width: 48%; float: right; margin-left: 3px;">
    <fieldset>
        <legend><h2>Configuración</h2></legend>
        <label>Numero de cliente Waltook: </label> <?php echo $num_cliente; ?><br />
        <label>Codigo de encriptacion(key): </label> <?php echo $clave; ?><br /><br />
    </fieldset>
</div>

<br />

<script>
$(function(){ $(".boton").button(); });

function cargarSms() {

}
</script>

<div style="float: left; clear: both;">
    <fieldset>
        <legend><h2>Mensajes recibidos</h2></legend>
        <p>Usted tiene <span id="cantidad_sms">N</span> mensajes recibidos</p><br />
        <table>
            <tbody>
                <th>Teléfono</th>
                <th>Fecha y hora</th>
                <th>Mensaje</th>
                <th>Paciente</th>
                <th>Acciones</th>
                <tr>
                    <td>2314243452</td>
                    <td>fechahora</td>
                    <td>dadisadpioasdpoiadspoiadspoiasdpioasdpoiadsipoasdipodasoipasdpioadsipoasdipoads</td>
                    <td>Paciente, Paciente</td>
                    <td>
                        <?php echo $this->Html->tag( 'a', 'Leer', array( 'class' => 'boton' ) ); ?>
                        <?php echo $this->Html->tag( 'a', 'Eliminar', array( 'class' => 'boton' ) ); ?>
                    </td>
                </tr>
            </tbody>
        </table>

    </fieldset>

</div>
