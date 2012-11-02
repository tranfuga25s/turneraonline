<?php $this->set( 'title_for_layout', "Informar error" ); ?>
<div class="decorado1">
    <div class="titulo2">Informar un error</div>
    <div>
        <b>GRACIAS POR REPORTAR ESTE ERROR</b><br />
        Utilice el siguiente formulario para enviarnos la descripción del error:
        <?php
            echo $this->Form->create( 'contacto' );
            echo $this->Form->input( 'descripcion_corta', array( 'label' => 'Descripcion corta' ) );
            echo $this->Form->input( 'detalle', array( 'label' => 'Detalle del error', 'between' => '¿Que estaba haciendo cuando sucedió el error en el sistema?<br />', 'cols' => 40, 'rows' => 15 ) );
            echo $this->Form->input( 'contactar', array( 'type' => 'checkbox', 'label' => 'Mangenerme al tanto de la solucion' ) );
            echo $this->Form->input( 'nombre', array( 'label' => "Su nombre" ) );
            echo $this->Form->input( 'email', array( 'label' => "Su e-mail" ) );
            echo $this->Form->end( 'Enviar' );
        ?>  
    </div>
</div>