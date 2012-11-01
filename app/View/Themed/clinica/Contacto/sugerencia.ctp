<?php $this->set( 'title_for_layout', "Enviar sugerencia" ); ?>
<div class="decorado1">
    <div class="titulo2">Enviar una sugerencia para el sistema</div>
    <div>
        <b>Muchas Gracias por tomarse el tiempo de enviarnos una sugerencia!</b><br />
        Utilice el siguiente formulario para enviarnosla:
        <?php
            echo $this->Form->create( 'contacto' );
            echo $this->Form->input( 'descripcion_corta', array( 'label' => 'Titulo descriptivo' ) );
            echo $this->Form->input( 'detalle', array( 'rows' => 15, 'cols' => 40, 'label' => 'Detalle', 'between' => 'Sirvase en explayarse todo lo que considere necesario<br />' ) );
            echo $this->Form->input( 'contactar', array( 'type' => 'checkbox', 'label' => 'Mangenerme al tanto de la evolucion de la sugerencia' ) );
            echo $this->Form->input( 'nombre', array( 'label' => "Su nombre" ) );
            echo $this->Form->input( 'email', array( 'label' => "Su e-mail" ) );
            echo $this->Form->end( 'Enviar' );
        ?>  
    </div>
</div>