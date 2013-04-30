<?php $this->set( 'title_for_layout', "Enviar sugerencia" ); ?>
<h1>Enviar una sugerencia para el sistema</h1>
<p><b>Muchas Gracias por tomarse el tiempo de enviarnos una sugerencia!</b></p>
<div class="contacto form">
	<?php echo $this->Form->create( 'contacto' ); ?>
    <fieldset>
    	<legend>Utilice el siguiente formulario para enviarnos la sugerencia:</legend>
        <?php
            echo $this->Form->input( 'descripcion_corta', array( 'label' => 'Titulo descriptivo' ) );
            echo $this->Form->input( 'detalle', array( 'rows' => 15, 'cols' => 40, 'label' => 'Detalle', 'between' => 'Sirvase en explayarse todo lo que considere necesario<br />' ) );
            echo $this->Form->input( 'contactar', array( 'type' => 'checkbox', 'label' => 'Mangenerme al tanto de la evolucion de la sugerencia' ) );
		?>    	
    </fieldset>
    <?php echo $this->Form->end( 'Enviar' ); ?>  
</div>