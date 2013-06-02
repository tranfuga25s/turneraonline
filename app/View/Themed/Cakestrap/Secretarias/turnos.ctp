<?php
$this->set( 'modelo', 'secretarias' );
$this->extend( '/Turnos/turnos_dia' );
echo $this->Html->script( 'jquery.cookie', array( 'inline' => false ) );
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
// Activa la ultima pestaña si existe en las cookies
var lastTab = $.cookie("ultima_pestana");
if (lastTab) {
    $("ul.nav-tabs").children().removeClass("active");
    $("a[href="+ lastTab +"]").parents("li:first").addClass("active");
    $("div.tab-content").children().removeClass("active");
    $(lastTab).addClass("active");
} else {
    $("#pestanas a:first").tab("show");
}

// Coloca el alto del elemento según el alto de la pestaña elegida
$("#pestanas").css( "height", $( ".tab-content" ).height()+"px");
$("#pestanas a").click( function (e) {
  e.preventDefault();
  $("#pestanas").css( "height", $( $(this).attr( "data-target") ).height()+"px");
  $(this).tab("show");
  // Sistema para recordar la pestaña que se encuentra abierta
  $.cookie( "ultima_pestana", $(e.target).attr( "href" ) );
})
'); ?>
