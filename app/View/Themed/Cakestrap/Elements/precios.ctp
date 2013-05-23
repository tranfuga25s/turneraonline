<?php
$precio_subdominio = doubleval( $this->requestAction( array( 'plugin' => 'gestotux',
                                                             'controller' => 'gestotux',
                                                             'action' => 'precio',
                                                             $id_servicio['compartido'] ) ) );
$precio_dominio = doubleval( $this->requestAction( array( 'plugin' => 'gestotux',
                                                          'controller' => 'gestotux',
                                                          'action' => 'precio',
                                                          $id_servicio['dedicado'] ) ) );

$extras = Configure::read( 'Gestotux.extras' );
$precios['waltook']  = doubleval( $extras['waltook'] );
$precios['facebook'] = doubleval( $extras['facebook'] );


?>
<table class="table table-hover table-condensed table-bordered">
	<tbody>
		<tr>
			<th rowspan="2" class="text-left" style="vertical-align: middle;"><p class="text-center">Tipo de servicio</p></th>
			<th colspan="4" class="text-center" style="vertical-align: middle;"><p class="text-center">Incluye</p></th>
			<th rowspan="2" class="text-center" style="vertical-align: middle;"><p class="text-center">Precio final por mes</p></th>
		</tr>
		<tr>
			<th style="vertical-align: middle;"><p class="text-center">Servidor</th>
			<th style="vertical-align: middle;"><p class="text-center">Instalación</th>
			<th style="vertical-align: middle;"><p class="text-center">Dominio</th>
			<th style="vertical-align: middle;"><p class="text-center">Soporte 24/7</th>
		</tr>

		<tr class="info">
			<td class="text-center" style="vertical-align: middle;">Básico</td>
			<td style="vertical-align: middle;"><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td style="vertical-align: middle;"><p class="text-center"><span class="icon-ok">&nbsp;</span><br />Sin Cargo!</p></td>
			<td style="vertical-align: middle;"><p class="text-center">Subdominio<br /><small>minombre.turnossantafe.com.ar</small></p></td>
			<td style="vertical-align: middle;"><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td style="vertical-align: middle;"><p class="text-center"><?php echo $this->Number->currency( $precio_subdominio, 'USD', array( 'class' => 'text-center') ); ?></p></td>
		</tr>

		<tr class="warning">
			<td class="text-center" style="vertical-align: middle;">Dedicado</td>
			<td style="vertical-align: middle;"><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td style="vertical-align: middle;"><p class="text-center"><span class="icon-ok">&nbsp;</span><br />Sin Cargo!</p></td>
			<td style="vertical-align: middle;"><p class="text-center">Propio<br />www.minombre.com.ar</p></td>
			<td style="vertical-align: middle;"><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td style="vertical-align: middle;"><p class="text-center"><?php echo $this->Number->currency( $precio_dominio, 'USD', array( 'class' => 'text-center') ); ?></p></td>
		</tr>

		<tr>
			<td colspan="6"><h5>Extras opcionales</h5></td>
		</tr>
		<tr class="success">
			<td colspan="4" style="vertical-align: middle;">Integración con Facebook</td>
			<td colspan="2" style="vertical-align: middle;">
			    <p class="text-center"> <?php echo $this->Number->currency( $precios['facebook'], 'USD', array( 'class' => 'text-center') ); ?>*</p>
			</td>
		</tr>
		<tr class="success">
			<td colspan="4" style="vertical-align: middle;">Mensajes SMS</td>
			<td colspan="2" style="vertical-align: middle;"><p class="text-center"><?php echo $this->Number->currency( $precios['waltook'], 'USD', array( 'class' => 'text-center') ); ?>* **</p></td>
		</tr>

	</tbody>
</table>
<small>* En activación</small><br />
<small>** Tiene recargo por mensaje</small>