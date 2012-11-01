Muchas gracias por utilizar nuestros servicios!

Este email tiene como finalidad recordarle que usted posee un turno pendiente proximamente

Datos del turno
----- --- -----
Fecha: <?php echo date( 'd/m/Y', strtotime( $turno['Turno']['fecha_inicio'] ) ); ?>
Hora de inicio: <?php echo date( 'H:i', strtotime( $turno['Turno']['fecha_inicio'] ) ); ?>
Medico: <?php echo $medico['Usuario']['razonsocial']; ?>
Consultorio: <?php echo $consultorio['Consultorio']['nombre']; ?>
Clinica: <?php echo $clinica['Clinica']['nombre']; ?>

No responda a este email.
Fue generado automaticamente por el sistema. Si desea escribirnos hagalo a <?php echo $email_de; ?>.