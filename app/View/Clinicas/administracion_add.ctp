<h2>Agregar nueva clinica</h2>
<div class="clinicas form">
	<?php echo $this->Form->create('Clinica');?>
	<fieldset>
	<?php
		echo $this->Form->input('nombre', array( 'type' => 'text' ) );
		echo $this->Form->input('direccion');
		echo $this->Form->input('telefono');
		echo $this->Form->input('email');
		
		echo $this->Form->hidden('lat', array('label' => 'Latitud', 'readonly'));
        echo $this->Form->hidden('lng', array('label' => 'Longitud', 'readonly'));
		echo $this->Html->tag('p', 'Arrastre el marcador a la posición deseada donde se ubica su clinica');
        // <editor-fold defaultstate="collapsed" desc="google map code">
        echo $this->GoogleMapV3->map(array(
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
		
	?>
	</fieldset>
	<?php echo $this->Form->end( 'Agregar' );?>
</div>
<div class="actions">
	<h3>Acciones</h3>
	<ul>
		<li><?php echo $this->Html->link( 'Listado de Clinicas', array( 'action' => 'index' ) ); ?></li>
	</ul>
</div>
