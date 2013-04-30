<?php
$precio = doubleval( $this->requestAction( array( 'plugin' => 'gestotux', 'controller' => 'gestotux', 'action' => 'precio', $id_servicio ) ) );

$recargo = Configure::read( 'Gestotux.recargos' );

// Armo el array de precios
$precios['base']  = $precio * ( 1.0 + doubleval( $recargo['basico'] ) );
$precios['extra'] = $precio * ( 1.0 + doubleval( $recargo['extra'] ) / 100.0 );
$precios['full']  = $precio * ( 1.0 + doubleval( $recargo['full'] ) / 100.0 );

$extras = Configure::read( 'Gestotux.extras' );
$precios['waltook']  = doubleval( $extras['waltook'] );
$precios['facebook'] = doubleval( $extras['facebook'] );
?>
<table class="table table-hover table-condensed table-bordered">
	<tbody>
		<tr>
			<th rowspan="2" class="text-left"><p class="text-center">Tipo de servicio</p></th>
			<th colspan="4" class="text-center"><p class="text-center">Incluye</p></th>
			<th rowspan="2" class="text-center"><p class="text-center">Precio final por mes</p></th>
		</tr>
		<tr>
			<th><p class="text-center">Servidor</th>
			<th><p class="text-center">Instalación</th>
			<th><p class="text-center">Manual Impreso</th>
			<th><p class="text-center">Soporte 24/7</th>
		</tr>
		
		<tr class="info">
			<td class="text-center"><?php echo $nombre; ?> Básico</td>
			<td><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><p class="text-center"><?php echo $this->Number->currency( $precios['base'], 'USD', array( 'class' => 'text-center') ); ?></p></td>
		</tr>
		
		<tr class="warning">
			<td class="text-center"><?php echo $nombre; ?> Extra</td>
			<td><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td>&nbsp;</td>
			<td><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td><p class="text-center"><?php echo $this->Number->currency( $precios['extra'], 'USD', array( 'class' => 'text-center') ); ?></p></td>
		</tr>

		<tr class="success">
			<td class="text-center"><?php echo $nombre; ?> Full</td>
			<td><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td><p class="text-center"><?php echo $this->Number->currency( $precios['full'], 'USD', array( 'class' => 'text-center') ); ?></p></td>
		</tr>

		<tr>
			<td colspan="6"><h5>Extras opcionales</h5></td>
		</tr>
		<tr class="success">
			<td colspan="4">Integración con Facebook</td>
			<td colspan="2"><p class="text-center">+ <?php echo $this->Number->currency( $precios['facebook'], 'USD', array( 'class' => 'text-center') ); ?></p></td>
		</tr>
		<tr class="success">
			<td colspan="4">Mensajes SMS</td>
			<td colspan="2"><p class="text-center">+ <?php echo $this->Number->currency( $precios['waltook'], 'USD', array( 'class' => 'text-center') ); ?></p></td>
		</tr>

	</tbody>
</table>