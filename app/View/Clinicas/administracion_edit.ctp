<div class="clinicas form">
<?php echo $this->Form->create('Clinica');?>
	<fieldset>
		<legend><h2>Editar clinica</h2></legend>
	<?php
		echo $this->Form->input('id_clinica');
		echo $this->Form->input('nombre', array( 'type' => 'text' ) );
		echo $this->Form->input('direccion');
		echo $this->Form->input('telefono', array( 'type' => 'text' ) );
		echo $this->Form->input('email');
		
		// Seccion de mapa
		echo $this->Form->hidden('lat', array('label' => 'Latitud', 'readonly'));
        echo $this->Form->hidden('lng', array('label' => 'Longitud', 'readonly'));
		echo $this->Html->tag('p', 'Arrastre el marcador a la posición deseada donde se ubica su clinica');
        
        echo $this->GoogleMapV3->map( array( 'div' => array( 'height'=>'400', 'width'=>'100%' ), "autoScript" => true ) );

        //add marker
        $options = array(
            'lat' => ( $this->request->data['Clinica']['lat'] == null ) ? 50 : $this->request->data['Clinica']['lat'],
            'lng' => ( $this->request->data['Clinica']['lng'] == null ) ? 50 : $this->request->data['Clinica']['lng'],	
            'directions' => false,
            'content' => '',
            'center' => true,
            'title' => $this->request->data['Clinica']['nombre'] # optional
        );

        //set event when drag to update lng and lat
        $this->GoogleMapV3->addMarker($options);
        $event = "var actualPosition=x0.getPosition();
                         $('#ClinicaLng').val(actualPosition.lng()); 
                         $('#ClinicaLat').val(actualPosition.lat());";
        $this->GoogleMapV3->addCustomEvent(0, $event, "dragend");
        $this->GoogleMapV3->addCustomEvent(0, $event, "drag");
        
        // print js
		echo $this->GoogleMapV3->script();
		
	?>
	</fieldset>
<?php echo $this->Form->end( 'Guardar');?>
</div>

