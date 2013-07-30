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
                    <td style="text-align: right;">Mensajes para enviar:</td>
                    <td><?php echo $saldo['salida']; ?> mensajes</td>
                </tr>
                <tr>
                    <td style="text-align: right;">Mensajes a recibir:</td>
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
        <label>Codigo de encriptacion(key): </label> <?php echo $clave; ?><br />
        <label>Codigo de respuesta: </label> <?php echo $codigo_respuesta; ?><br />
    </fieldset>
</div>

<br />

<?php echo $this->Js->buffer( '$(".boton").button();' ); ?>
</script>

<div style="float: left; clear: both; width: 100%;">
    <fieldset>
        <legend><h2>Mensajes recibidos</h2></legend>
        <p>Usted tiene <?php echo count( $mensajes ); ?> mensajes recibidos</p><br />
        <table>
            <tbody>
                <th>Teléfono</th>
                <th>Fecha y hora</th>
                <th>Mensaje</th>
                <th>Paciente</th>
                <th>Acciones</th>
                <?php foreach( $mensajes as $mensaje ): ?>
                <tr>
                    <td><?php echo $mensaje['Sms']['uid']; ?></td>
                    <td><?php echo h( $mensaje['Sms']['fechahora'] ); ?></td>
                    <td><?php echo $mensaje['Sms']['texto']; ?></td>
                    <td><?php echo $mensaje['Paciente']['razonsocial']; ?></td>
                    <td>
                        <?php //echo $this->Html->tag( 'a', 'Eliminar', array( 'class' => 'boton' ) ); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </fieldset>

</div>
<?php echo $this->Js->writeBuffer(); ?>
