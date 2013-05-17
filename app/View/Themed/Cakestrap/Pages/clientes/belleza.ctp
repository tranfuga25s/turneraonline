<?php 
$this->set( 'title_for_layout', "Sistema de turnos para salones de belleza" ); 
?>
<div class="row-fluid">
	<div class="span12">
		<h3>Sistema de turnos para salones de belleza</h3>
		<p>	Todo el sistema se encuentra preparado para que una o várias personas puedan administrarlo.</p>
	</div>
</div>
<div class="row-fluid">
	<div class="span6">
		<div class="well">
			<h4>Caraterísticas</h4>
			<table class="table table-condensed table-hover">
				<tbody>
					<tr>
						<td width="20"><span class="icon-check">&nbsp;</span></td>
						<td align="left">Todo es administrable por la secretaria o las encargadas del salón de belleza.</td>
					</tr>
					<tr>
						<td width="20"><span class="icon-check">&nbsp;</span></td>
						<td>Ventana de turnos auto-actualizable para cada parte del salón.</td>
					</tr>
					<tr>
						<td width="20"><span class="icon-check">&nbsp;</span></td>
						<td>P&aacute;gina personalizada como p&aacute;gina personal y de contacto.</td>
					</tr>
					<tr>
						<td width="20"><span class="icon-check">&nbsp;</span></td>
						<td>Mensaje de resumen diario por email.</td>
					</tr>
				</tbody>
			</table>
		</div>
	
		<div class="well">
			<h4>Extras Opcionales</h4>
			<table class="table table-condensed table-hover">
				<tbody>
					<tr>
						<td><span class="icon-check">&nbsp;</span></td>
						<td>Aviso por mensaje de texto.
							<span class="pull-right"><?php echo $this->Html->link( 'Más información', array( 'controller' => 'pages', 'action' => 'display', 'extras','waltook' ), array( 'class' => 'btn btn-primary') ); ?></span>
						</td>
					</tr>
					<tr>
						<td><span class="icon-check">&nbsp;</span></td>
						<td>Integración con Facebook.
							<span class="pull-right"><?php echo $this->Html->link( 'Más información', array( 'controller' => 'pages', 'action' => 'display', 'extras','facebook' ), array( 'class' => 'btn btn-primary') ); ?></span>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="span6 well">
		<h4>Precios</h4>
		<?php echo $this->element( 'precios', array( 'id_servicio' => intval( Configure::read( 'Gestotux.id_servicio.belleza' ) ), 'nombre' => "Salón de belleza" ) ); ?>
	</div>
	
</div>