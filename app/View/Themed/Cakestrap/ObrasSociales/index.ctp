<?php $this->set( 'title_for_layout', "Lista de obras sociales disponibles" ); ?>
<div class="navbar">
	<div class="navbar-inner">
		<ul class="nav nav-pills">
			<li><?php echo $this->Html->link( 'Inicio', '/' ); ?></li>
			<li class="active"><?php echo $this->Html->link( 'Obras Sociales', '#' ); ?></li>
			<li><?php echo $this->Html->link( 'Nuevo turno', array( 'controller' => 'turnos', 'action' => 'nuevo' ) ); ?></li>
			<li><?php echo $this->Html->link( 'Mis datos', array( 'controller' => 'usuarios', 'action' => 'view' ) ); ?></li>
			<li><?php echo $this->Html->link( 'Salir', array( 'controller' => 'usuarios', 'action' => 'salir' ) ); ?></li>
		</ul>
	</div>
</div>

<div class="row-fluid">
	<h3>Listado de Obras Sociales Disponibles</h3>
	<p>Estas son las obras sociales con las que trabajamos. Pulse sobre el logo para ver m&aacute;s datos.</p>
	<div class="obras-sociales">
		<ul class="thumbnails">
			<?php foreach( $obrasSociales as $obraSocial ) :
				if( is_null( $obraSocial['ObraSocial']['logo'] ) ) { $obraSocial['ObraSocial']['logo'] = 'cabecera.png'; } ?>
				<li class="span1 thumbnail">
					<?php echo $this->Html->link( $this->Html->image( $obraSocial['ObraSocial']['logo'] ), 
												  array( 'action' => 'view', $obraSocial['ObraSocial']['id_obra_social'] ),
					  							  array( 'escape' => false ) ); ?><br />
					<?php echo $this->Html->link( h( $obraSocial['ObraSocial']['nombre'] ), array( 'action' => 'view', $obraSocial['ObraSocial']['id_obra_social'] ) ); ?>
				</li>
		   <?php endforeach; ?>
		</ul>
	</div>	
</div>

<br />
<div class="decorado1">
	<div class="contenedor-os">
		
	</div>
</div>