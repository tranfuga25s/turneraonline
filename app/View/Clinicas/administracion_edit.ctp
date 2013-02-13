<div class="clinicas form">
<?php echo $this->Form->create('Clinica');?>
	<fieldset>
		<legend><h2>Editar clinica</h2></legend>
	<?php
		echo $this->Form->input('id_clinica');
		echo $this->Form->input('nombre', array( 'type' => 'text' ) );
		echo $this->Form->input('direccion');
		echo $this->Form->input('telefono');
		echo $this->Form->input('email');
		
		// Seccion de mapa
		echo $this->Form->hidden('lat', array('label' => 'Latitud', 'readonly'));
        echo $this->Form->hidden('lng', array('label' => 'Longitud', 'readonly'));
		echo $this->Html->tag('p', 'Arrastre el marcador a la posición deseada donde se ubica su clinica');
        // <editor-fold defaultstate="collapsed" desc="google map code">
        echo $this->GoogleMapV3->map(array(
            'lat' => $this->data['Clinica']['lat'],
            'lng' => $this->data['Clinica']['lng'],
            /*'zoom' => Configure::read('GoogleMaps.zoom'),*/
            'div' => array(
                'id' => 'my_map',
                'height' => '166',
                'width' => '306',
                'frameborder' => '0',
                'marginheight' => '0',
                'marginwidth' => '0',
            )
          )
        );
        //add marker
        $options = array(
            'lat' => $this->data['Clinica']['lat'],
            'lng' => $this->data['Clinica']['lng'],
            'color' => 'green',
            'directions' => true,
            'center' => true,
            'title' => $this->data['Clinica']['nombre'] # optional
        );
        //set event when drag to update lng and lat
        $this->GoogleMapV3->addMarker($options);
        $event = "var actualPosition=x0.getPosition();
                         $('#ClinicaLng').val(actualPosition.lng()); 
                         $('#ClinicaLat').val(actualPosition.lat());";
        $this->GoogleMapV3->addCustomEvent(0, $event, "dragend");
        $this->GoogleMapV3->addCustomEvent(0, $event, "drag");
		
		
		/*echo $this->Form->input( 'lat' );
		echo $this->Form->input( 'lng' );*/
	?>
	</fieldset>
<?php echo $this->Form->end( 'Guardar');?>
</div>

