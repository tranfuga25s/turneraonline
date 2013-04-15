<?php
$this->set( 'title_for_layout', "Notificaciones" );
?>
<div id="acciones">
	Configurar:
	<?php echo $this->Html->link( 'Email', array( 'action' => 'email' ) ); ?>
	<?php echo $this->Html->link( 'SMS', array( 'action' => 'sms' ) ); ?>
	&nbsp; | Ver: 
	<?php echo $this->Html->link( 'Notificaciones Pendientes', array( 'action' => 'pendiente' ) ); ?>
</div>
<br />
<div class="index">
	<h2>Notificaciones</h2>
	<p>Elija que elementos se enviarán a los usuarios de su sistema</p>
	<table>
		<tbody>
			<th>Elemento</th>
			<th>Email</th>
			<th>SMS</th>
			<tr>
				<td>Aviso de nuevo turno</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Aviso de cancelación de turno</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Aviso de cancelación de turno</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Aviso de cancelación de turno</td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
	</table>
</div>
