<div>
<h3>Muchas gracias por utilizar nuestros servicios!</h3>
<br />
Este email tiene como finalidad recordarle que usted posee un turno pendiente pr&oacute;ximamente<br />
<br />
<b>Datos del turno:</b>
<br />
<b>Fecha:</b> <?php echo date( 'd/m/Y', strtotime( $turno['Turno']['fecha_inicio'] ) ); ?><br />
<b>Hora de inicio:</b> <?php echo date( 'H:i', strtotime( $turno['Turno']['fecha_inicio'] ) ); ?><br />
<b>M&eacute;dico:</b> <?php echo $medico['Usuario']['razonsocial']; ?><br />
<b>Consultorio:</b> <?php echo $consultorio['Consultorio']['nombre']; ?><br />
<b>Cl&iacute;nica:</b> <?php echo $clinica['Clinica']['nombre']; ?><br />
<br />
<i>No responda a este email.</i><br />
Fue generado autom&aacute;ticamente por el sistema. Si desea escribirnos hagalo a <a href="mailto:<?php echo $email_de; ?>"><?php echo $email_de; ?></a>
<br />
</div>
