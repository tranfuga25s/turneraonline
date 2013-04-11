<?php $this->set( 'title_for_layout', "Datos de la obra social" ); ?>
<div class="navbar">
	<div class="navbar-inner">
		<ul class="nav nav-pills">
			<li><?php echo $this->Html->link( 'Inicio', '/' ); ?></li>
			<li><?php echo $this->Html->link( 'Listado de Obras Sociales', array( 'action' => 'index' ) ); ?></li>
			<li class="active"><?php echo $this->Html->link( h( $obrasSociale['ObraSocial']['nombre'] ), '#' ); ?></li>
			<li><?php echo $this->Html->link( 'Nuevo turno', array( 'controller' => 'turnos', 'action' => 'nuevo' ) ); ?></li>
			<li><?php echo $this->Html->link( 'Mis datos', array( 'controller' => 'usuarios', 'action' => 'view' ) ); ?></li>
			<li><?php echo $this->Html->link( 'Salir', array( 'controller' => 'usuarios', 'action' => 'salir' ) ); ?></li>
		</ul>
	</div>
</div>
<div class="row-fluid">
	<div class="span5">
		<h2>Datos de la obra social</h2>
		<table class="table table-hover table-condensed">
			<tbody>
				<tr>
					<td>Raz&oacute;n Social</td>
					<td><?php echo h($obrasSociale['ObraSocial']['nombre']); ?>&nbsp;</td>
				</tr>
				<tr>
					<td>Direcci&oacute;n</td>
					<td><?php echo h($obrasSociale['ObraSocial']['direccion']); ?>&nbsp;</td>
				</tr>
				<tr>
					<td>Tel&eacute;fono</td>
					<td><?php echo h($obrasSociale['ObraSocial']['telefono']); ?>&nbsp;</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>