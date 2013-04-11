<table class="table table-hover table-condensed table-bordered">
	<tbody>
		<tr>
			<th rowspan="2" class="text-left"><p class="text-center">Tipo de servicio</p></th>
			<th colspan="4" class="text-center"><p class="text-center">Incluye</p></th>
			<th rowspan="2" class="text-center"><p class="text-center">Precio final</p></th>
		</tr>
		<tr>
			<th><p class="text-center">Servidor</th>
			<th><p class="text-center">Instalación</th>
			<th><p class="text-center">Manual Impreso</th>
			<th><p class="text-center">Soporte 24/7</th>
		</tr>
		
		<tr class="info">
			<td class="text-center">Medico Básico</td>
			<td><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><p class="text-center"><?php echo $this->Number->currency( '2222.34', 'USD', array( 'class' => 'text-center') ); ?></p></td>
		</tr>
		
		<tr class="warning">
			<td class="text-center">Médico Extra</td>
			<td><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td>&nbsp;</td>
			<td><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td><p class="text-center"><?php echo $this->Number->currency( '2222.34', 'USD', array( 'class' => 'text-center') ); ?></p></td>
		</tr>

		<tr class="success">
			<td class="text-center">Médico Full</td>
			<td><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td><p class="text-center"><span class="icon-ok">&nbsp;</span></p></td>
			<td><p class="text-center"><?php echo $this->Number->currency( '2222.34', 'USD', array( 'class' => 'text-center') ); ?></p></td>
		</tr>

		<tr>
			<td colspan="6">Extras opcionales</td>
		</tr>
		<tr class="success">
			<td colspan="4">Integración con Facebook</td>
			<td colspan="2"><p class="text-center">+ <?php echo $this->Number->currency( '2222.34', 'USD', array( 'class' => 'text-center') ); ?></p></td>
		</tr>
		<tr class="success">
			<td colspan="4">Mensajes SMS</td>
			<td colspan="2"><p class="text-center">+ <?php echo $this->Number->currency( '2222.34', 'USD', array( 'class' => 'text-center') ); ?></p></td>
		</tr>

	</tbody>
</table>