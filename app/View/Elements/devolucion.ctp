<?php
 // Muestra el formulario para generar devoluciónes desde el usuario
 
 ?>
 <!--
 <script>
     $(function() {
         $("a","#slider").button();
        $("#botonfeedback").bind( 'click',
            function() {
                $("#slider").show( 'slide', {direction: 'right'}, 1000);
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
     overflow: hidden;
     position: relative;
     min-width: 300px;
     right: -30px;
 }
 </style>
 <div id="devolucion" class="ui-widget-active ui-widget-content">
     <div id="slider">
         <?php echo $this->Html->tag( 'a', '<<', array( 'id' => "botonfeedback" ) ); ?>
         <?php echo $this->Html->link( 'Error!', array( 'controller' => 'contacto', 'action' => 'error' ) ); ?>
         <?php echo $this->Html->link( '¿Sugerencia?', array( 'controller' => 'contacto', 'action' => 'sugerencia' ) ); ?>
        <?php ?>         
     </div>
 </div>
 -->