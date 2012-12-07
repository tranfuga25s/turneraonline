<?php $this->set( 'title_for_layout', "Informar error" ); ?>
<h1>GRACIAS POR REPORTAR ESTE ERROR</h1>
<div class="contacto form">
	<?php echo $this->Form->create( 'contacto' ); ?>
	<fieldset>
		<legend>Informar un error</legend>
        Utilice el siguiente formulario para enviarnos la descripción del error:
        <?php
			echo $this->Form->input( 'direccion', array( 'type' => 'hidden', 'value' => $direccion_error ) );
            echo $this->Form->input( 'descripcion_corta', array( 'label' => 'Descripcion corta' ) );
            echo $this->Form->input( 'detalle', array( 'label' => 'Detalle del error', 'between' => '¿Que estaba haciendo cuando sucedió el error en el sistema?<br />', 'cols' => 40, 'rows' => 15 ) );
            echo $this->Form->end( 'Enviar' );
        ?>  
    </fieldset>
</div>