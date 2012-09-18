<?php
 // Muestra el formulario para generar devoluciónes desde el usuario
 
 ?>
 <script>
     $(function() {
         $("a","#slider").button();
        $("#botonfeedback").bind( 'click',
            function() {
                $("#slider").animate( { 'right' :  '235px' }, 1000);
                $("#botonfeedback").html( '>>' );
            } 
        ); 
     });
 </script>
 <style>
 #devolucion {
    float: right;
    max-width: 10px;
    position: relative;
    top: -70px;
 }
 
 #slider {
    border: 1px solid slateblue;
    border-radius: 4px 4px 4px 4px;
    min-width: 300px;
    overflow: hidden;
    padding: 2px;
    position: relative;
    right: -40px;
 }
 </style>
 <div id="devolucion" class="ui-widget-active ui-widget-content">
     <div id="slider">
         <?php echo $this->Html->tag( 'a', '<<', array( 'id' => "botonfeedback" ) ); ?>
         <?php echo $this->Html->link( 'Error!', array( 'controller' => 'contacto', 'action' => 'error' ) ); ?>
         <?php echo $this->Html->link( '¿Sugerencia?', array( 'controller' => 'contacto', 'action' => 'sugerencia' ) ); ?>
     </div>
 </div>