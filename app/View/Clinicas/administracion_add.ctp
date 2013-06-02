<?php $this->set( 'title_for_layout', "Agregar nueva clinica" ); ?>
<div id="acciones">
    <?php echo $this->Html->link( 'Lista de clinicas', array( 'action' => 'index' ) ); ?>
</div>
<br />
<div class="clinicas form">
	<?php echo $this->Form->create('Clinica');?>
	<fieldset>
	<legend><h2>Agregar nueva clinica</h2></legend>
	<?php
		echo $this->Form->input('nombre', array( 'type' => 'text' ) );
		echo $this->Form->input('direccion');
		echo $this->Form->input('telefono', array( 'type' => 'text' ) );
		echo $this->Form->input('email');

		echo $this->Form->hidden('lat', array('label' => 'Latitud', 'readonly'));
        echo $this->Form->hidden('lng', array('label' => 'Longitud', 'readonly'));
        echo $this->Form->hidden('zoom', array('label' => 'Zoom', 'readonly' ));
		echo $this->Html->tag('p', 'Arrastre el marcador a la posición deseada donde se ubica su clinica');
        echo $this->GoogleMapV3->map(
        	array( 'div' => array(
        				'height' => '400',
        				'width' => '570' ),
        		 	"autoScript" => true ) );
        //add marker
        $options = array(
        	'lng' => -60.69913136959076,
        	'lat' => -31.633594220533507,
        	'title' => 'Arrastre hasta la ubicación real',
        	'content' => 'Mueva este marcador hasta la posición donde se encuentra su clinica y suelteló ahí'
        );

        //set event when drag to update lng and lat
        $this->GoogleMapV3->addMarker($options);
        $event = "var actualPosition=x0.getPosition();
                  $('#ClinicaLng').val(actualPosition.lng());
                  $('#ClinicaLat').val(actualPosition.lat());
                  $('#ClinicaZoom').val(this.map.zoom);";
        $eventozoom = "
        google.maps.event.addListener( map, 'zoom_changed', function() {
                $('#ClinicaZoom').val(this.map.zoom);
            });
        ";
        $this->GoogleMapV3->addCustomEvent(0, $event, "dragend");
        $this->GoogleMapV3->addCustomEvent(0, $event, "drag");
        $this->GoogleMapV3->addCustom($eventozoom);

		// print js
		echo $this->GoogleMapV3->script();

	?>
	</fieldset>
	<?php echo $this->Form->end( 'Agregar' );?>
</div>
