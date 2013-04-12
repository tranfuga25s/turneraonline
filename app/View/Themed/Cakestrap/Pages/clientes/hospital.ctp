<?php $this->set( 'title_for_layout', "Sistema de turnos para Hospitales y Sanatorios" ); ?>
<div class="row-fluid">
	<div class="span12">
		<h3>Sistema de turnos para Hospitales y Sanatorios</h3>
		Todo el sistema se encuentra preparado para que tanto m&eacute;dicos como secretarias sean capaces de administrarlo.<br />
		Cada secretaria puede tener a su cargo muchos consultorios y administrar sus turnos. El m&eacute;dico administra y mantiene todos sus turnos.<br /><br />
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
						<td align="left">Todo es administrable tanto por los m&eacute;dicos como por las secretarias.</td>
					</tr>
					<tr>
						<td width="20"><span class="icon-check">&nbsp;</span></td>
						<td>Ventana de turnos auto-actualizable para el m&eacute;dico y la secretaria.</td>
					</tr>
					<tr>
						<td width="20"><span class="icon-check">&nbsp;</span></td>
						<td>Se utiliza la p&aacute;gina como m&eacute;todo de contacto y administraci&oacute;n.</td>
					</tr>
					<tr>
						<td width="20"><span class="icon-check">&nbsp;</span></td>
						<td>Mensaje de resumen diario por email para cada secretaria.</td>
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
		<?php echo $this->element( 'precios', array( 'id_servicio' => Configure::read( 'Gestotux.id_servicio.hospital'), 
													 'nombre' => "Sanatorio" )
		 ); ?>
	</div>
	
</div>
