Bienvenido a nuestro sistema <?php echo $usuario['apellido']. ', '. $usuario['nombre']; ?>

Usted ha dado de alta correctamente su cuenta.
He aqui sus datos:

Nombre: <?php echo $usuario['nombre']; ?>
Apellido: <?php echo $usuario['apellido']; ?>
Telefono fijo: <?php echo $usuario['telefono']; ?>
Telefono Celular: <?php echo $usuario['celular']; ?> 
Dirección de email: <?php echo $usuario['email']; ?>

Si estos datos no son correctos, ingrese aqui para cambiarlos.

Si usted no solicito el alta de esta cuenta, utilice el siguiente link para eliminarla.
<?php echo $this->Html->url( array( 'controller' => 'usuarios', 'action' => 'cancelar', 'id_usuario' => $usuario['id_usuario'] ), true ); ?>

Muchas gracias.

Este email fue generado automaticamente.
No responda a esta dirección. Si desea comunicarse con nosotros escribanos a info@turnosonline.com.


