<?php
$this->set( 'title_for_layout', "Notificaciones" );
?>
<div id="acciones">
	<!-- Configurar:
	<?php echo $this->Html->link( 'Email', array( 'action' => 'email' ) ); ?>
	<?php echo $this->Html->link( 'SMS', array( 'action' => 'sms' ) ); ?>
	&nbsp;  |-->
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
				<td><?php echo $this->Html->image( 'test-pass-icon.png' ); ?></td>
				<td><?php echo $this->Html->image( 'test-fail-icon.png' ); ?></td>
			</tr>
			<tr>
				<td>Aviso de cancelación de turno</td>
				<td><?php echo $this->Html->image( 'test-pass-icon.png' ); ?></td>
				<td><?php echo $this->Html->image( 'test-fail-icon.png', array( 'alt' => 'El servicio no se encuentra habilitado' ) ); ?></td>
			</tr>
			<!--<tr>
				<td>Aviso de cancelación de turno</td>
				<td><?php echo $this->Html->image( 'test-pass-icon.png' ); ?></td>
				<td></td>
			</tr>
			<tr>
				<td>Aviso de cancelación de turno</td>
				<td><?php echo $this->Html->image( 'test-pass-icon.png' ); ?></td>
				<td></td>
			</tr> -->
		</tbody>
	</table>
	<h2>Estado de los servicios</h2>
	<p>Aqui está el listado de los servicios que están disponibles para los avisos.</p>
	<table>
		<tbody>
			<th>Servicio</th>
			<th>Estado</th>
			<th>Acciones</th>
			<tr>
				<td>Email</td>
				<td><?php echo $this->Html->image( 'test-pass-icon.png', array( 'El envío de mensajes por email está activo' ) ); ?></td>
				<td class="acciones">
					<!-- <?php echo $this->Html->link( 'Configurar', array( 'action' => 'configurar', 'elemento' => 'email' ) ); ?> -->
				</td>
			</tr>
			<tr>
				<td>SMS</td>
				<td>
				    <?php
				    if( $sms_habilitado ) {
                      echo $this->Html->image( 'test-pass-icon.png', array( 'alt' => 'El servicio se encuentra habilitado' ) );
                      echo $this->Html->tag( 'span', ' El servicio se encuentra habilitado' );				        
				    } else {
				      echo $this->Html->image( 'test-fail-icon.png', array( 'alt' => 'El servicio no se encuentra habilitado' ) );
                      echo $this->Html->tag( 'span', ' El servicio no se encuentra habilitado' );   
				    }
				   ?>
				</td>
				<td class="acciones">
					<?php
					if( $sms_habilitado ) {
                        echo $this->Html->link( 'Configurar', array( 'action' => 'configurar', 'sms' ) );					    
					} else {
					    echo $this->Html->link( 'Habilitar', array( 'action' => 'habilitar_sms' ) );    
					}
					?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<script>$("a",".acciones").button();</script>