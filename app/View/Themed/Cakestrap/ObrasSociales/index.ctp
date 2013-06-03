<?php $this->set( 'title_for_layout', "Lista de obras sociales disponibles" ); ?>

<div class="row-fluid">

	<?php
	if( isset( $usuarioactual ) ) {
	   echo $this->element( 'menu/usuario' );
        $ancho = 9;
	} else {
	    $ancho = 12;
	}
	?>

	<div class="span<?= $ancho; ?>">
		<h4>Listado de Obras Sociales Disponibles</h4>
		<p>Estas son las obras sociales con las que trabajamos. Pulse sobre el logo para ver m&aacute;s datos.</p>
		<ul class="media-list">
			<?php foreach( $obrasSociales as $obraSocial ) :
                if( is_null( $obraSocial['ObraSocial']['logo'] ) || $obraSocial['ObraSocial']['logo'] == '' ) { $obraSocial['ObraSocial']['logo'] = 'cabecera.png'; } ?>			<li class="media">
				<?php echo $this->Html->link( $this->Html->image( $obraSocial['ObraSocial']['logo'], array( 'class' => 'media-object' ) ),
													  array( 'action' => 'view', $obraSocial['ObraSocial']['id_obra_social'] ),
						  							  array( 'escape' => false, 'class' => 'pull-left' ) ); ?>
			    <div class="media-body">
			      <h4 class="media-heading"><?php echo $this->Html->link( h( $obraSocial['ObraSocial']['nombre'] ), array( 'action' => 'view', $obraSocial['ObraSocial']['id_obra_social'] ) ); ?></h4>
			      <address>
			      	<i class="icon-home"></i>&nbsp;<?php echo $obraSocial['ObraSocial']['direccion']; ?><br />
			      	<i class="icon-info-sign"></i>&nbsp;<?php echo $obraSocial['ObraSocial']['telefono']; ?><br />
			      </address>
			    </div>
			  </li>
			<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
