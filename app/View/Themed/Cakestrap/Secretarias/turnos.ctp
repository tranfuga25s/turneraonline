<?php
$this->set( 'modelo', 'secretarias' );
$this->extend( '/Turnos/turnos_dia' );
?>
<div class="tabbable tabs-left">
    <ul class="nav nav-tabs" id="pestanas">
    <?php foreach( $consultorios as $consultorio ) : ?>
        <li><?php echo $this->Html->tag( 'a', 
                                         $consultorio['Consultorio']['nombre'], 
                                         array( 'href' => '#'.$consultorio['Consultorio']['id_consultorio'],
                                                'data-toggle' => "tab",
                                                'data-target' => '#'.$consultorio['Consultorio']['id_consultorio'] ) ); ?></li>
    <?php endforeach; ?>  
  </ul>

  <div class="tab-content">
  <?php 
  foreach( $consultorios as $consultorio ):
    $this->set( 'turnos', $consultorio['Turnos'] );
    ?>
    <div class="tab-pane" id="<?php echo $consultorio['Consultorio']['id_consultorio']; ?>">
        <?php echo $this->element( 'Turnos/lista_turnos' ); ?>
    </div>
  <?php endforeach; ?>
  </div>
</div>
<?php 
$this->Js->buffer('
$("#pestanas a:first").tab("show");
$("#pestanas").css( "height", $( ".tab-content" ).height()+"px");
$("#pestanas a").click( function (e) {
  e.preventDefault();
  $("#pestanas").css( "height", $( $(this).attr( "data-target") ).height()+"px");
  $(this).tab("show");
}) '); ?>
