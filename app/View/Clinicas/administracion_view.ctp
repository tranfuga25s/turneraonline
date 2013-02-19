<?php $this->set( 'title_for_layout', "Datos de " . $clinica['Clinica']['nombre'] ); ?>
<div id="acciones">
	<?php echo $this->Html->link( 'Editar esta Clinica', array( 'action' => 'edit', $clinica['Clinica']['id_clinica'] ) ); ?>
	<?php echo $this->Form->postLink( 'Eliminar Clinica', array( 'action' => 'delete', $clinica['Clinica']['id_clinica'] ), null, __('Are you sure you want to delete # %s?', $clinica['Clinica']['id_clinica'] ) ); ?>
	<?php echo $this->Html->link( 'Lista de Clinicas', array( 'action' => 'index' ) ); ?>
	<?php echo $this->Html->link( 'Nueva Clinica', array( 'action' => 'add' ) ); ?>
</div>
<br />
<h2>Clinica</h2>
<dl>
	<dt>Nombre de la clinica:</dt>
	<dd>
		<?php echo h($clinica['Clinica']['nombre']); ?>
		&nbsp;
	</dd>
	<dt>Direcci&oacute;n:</dt>
	<dd>
		<?php echo h($clinica['Clinica']['direccion']); ?>
		&nbsp;
	</dd>
	<dt>Tel&eacute;fono</dt>
	<dd>
		<?php echo h($clinica['Clinica']['telefono']); ?>
		&nbsp;
	</dd>
	<dt>Logotipo</dt>
	<dd>
		<?php
		if( !empty( $clinica['Clinica']['logo'] ) ) {
			echo $this->Html->image( $clinica['Clinica']['logo'], array( 'alt' => $clinica['Clinica']['nombre'], 'height' => 150 ) );
		} else {
			echo "No ingreso ningún logotipo";
		} ?>
		&nbsp;
	</dd>
	<dt>Ubicacion:</dt>
	<dd>
		<?php
		// init map (prints container)
		echo $this->GoogleMapV3->map( 
		    array( 'div' => 
			array( 	'height'=>'400', 
				'width'=>'100%' ),
			 "autoScript" => true,
			 "zoom" => 20 ) );
		
		 
		// add markers
		$options = array(
			/*'lat' => 50,
			'lng' => 50,*/
		    'lat' => ( $clinica['Clinica']['lat'] == null ) ? 50 : $clinica['Clinica']['lat'],
		    'lng' => ( $clinica['Clinica']['lng'] == null ) ? 50 : $clinica['Clinica']['lng'],
		    'color' => 'green',
		    'center' => true,
		    //'icon'=> 'url_to_icon', // optional
		    'title' => $clinica['Clinica']['nombre'], // Titulo de el globito
		    'content' => $clinica['Clinica']['direccion'].'<br />'
		    		     .$clinica['Clinica']['telefono'].'<br />'
		    		     .'<a href="mailto:'.$clinica['Clinica']['email'].'">'.$clinica['Clinica']['email'].'</a>'
		);
		
		$this->GoogleMapV3->addMarker($options); // Agrego el marcador
		
		
		// print js
		echo $this->GoogleMapV3->script();
	?>
	</dd>
</dl>
<br />