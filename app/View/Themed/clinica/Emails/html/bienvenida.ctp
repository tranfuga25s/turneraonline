<h2>Bienvenido a nuestro sistema <?php echo $usuario['apellido']. ', '. $usuario['nombre']; ?></h2>
<br />
Usted ha dado de alta correctamente su cuenta.<br />
He aqui sus datos:<br />
<br />
<b>Nombre:</b>&nbsp;<?php echo $usuario['nombre']; ?><br />
<b>Apellido:</b>&nbsp;<?php echo $usuario['apellido']; ?><br />
<b>Telefono fijo:</b>&nbsp;<?php echo $usuario['telefono']; ?><br />
<b>Telefono Celular:</b>&nbsp;<?php echo $usuario['celular']; ?> <br />
<b>Dirección de email:</b>&nbsp;<?php echo $usuario['email']; ?><br />
<br />
Si estos datos no son correctos, ingrese aqui para cambiarlos.<br />
<br />
Si usted no solicito el alta de esta cuenta, utilice el siguiente link para eliminarla.<br />
<?php echo $this->Html->url( array( 'controller' => 'usuarios', 'action' => 'cancelar', 'id_usuario' => $usuario['id_usuario'] ), true ); ?>
<br />
Muchas gracias.<br />
<br />
Este email fue generado automaticamente.<br />
No responda a esta dirección. Si desea comunicarse con nosotros escribanos a <?php echo $this->Html->link( 'info@alejandrotanin.com.ar', 'mailto:info@alejandrotanin.com.ar' ); ?>.<br />
<br />
