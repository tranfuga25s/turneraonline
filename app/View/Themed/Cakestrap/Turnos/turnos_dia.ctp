<?php $this->set( 'title_for_layout', 'Turnos del día' ); ?>
<!-- Vista para heredar -->
<script type="text/javascript" language="JavaScript">
<?php if( $actualizacion == true ) { ?>
var actualizar = true;
<?php } else { ?>
var actualizar = false;
<?php } ?>

function cambiarDia() {
 actualizar = false;
 if( $("#seldia").css( 'display' ) == 'none' ) {
    $("#seldia").css( 'display', 'block' );
    $("#seldia").alert();
 } else {
    $("#seldia").slideUp();
 }
}

function cancelarTurnos( que ) {
    $("#MedicoIdMedico").clone().attr( 'value', que ).attr( 'name', 'data[Medico][que]' ).appendTo( "#cancelar2");
    $("#cancelar2").submit();
}

function mostrarCancelarTurnos() {
    if( $("#cancelar").css( 'display' ) == 'none' ) {
        $("#cancelar").slideDown();
        $("#cancelar").alert();
    } else {
        $("#cancelar").slideUp();
    }
}
</script>

<div class="row-fluid">

    <div class="navbar">
        <div class="navbar-inner">
            <ul class="nav">
                <li><?php echo $this->Html->link( 'Inicio', '/' ); ?></li>
                <li><?php echo $this->Html->tag( 'a', 'Cambiar día', array( 'id' => 'cambiarDia', 'onclick' => 'cambiarDia()' ) ); ?></li>
                <?php if( $hoy ): ?>
                <li><?php echo $this->Html->tag( 'a', 'Cancelar turnos', array( 'onclick' => 'mostrarCancelarTurnos()' ) ); ?></li>
                <?php endif; ?>
                <li><?php echo $this->Html->link( 'Pacientes', array( 'controller' => 'usuarios', 'action' => 'index' ) ); ?></li>
                <li><?php echo $this->Html->link( 'Salir', array( 'controller' => 'usuarios', 'action' => 'salir' ) ); ?></li>
            </ul>
            <ul class="nav pull-right">
                <li class="active"><?php echo $this->Html->tag( 'a', $fechas ); ?></li>
            </ul>
        </div>
    </div>

</div>

<div id="seldia" style="display:none;" class="alert alert-info">
   <button type="button" class="close" data-dismiss="seldia">&times;</button>
   <?php echo $this->Form->create( $modelo, array( 'action' => 'turnos', 'class' => 'form-inline' ) ); ?>
   <fieldset>
        Elija el día que desea:
        <?php echo $this->Form->input( 'id_medico', array( 'type' => 'hidden', 'value' => 0 ) ); ?>
        <?php echo $this->Form->input( 'accion', array( 'type' => 'hidden', 'value' => false ) ); ?>
        <div class="btn-toolbar">
            <div class="btn-group"><?php  echo $this->Html->tag( 'a', '< Dia', array(  'class' => 'btn', 'onclick' => '$("#'.$modelo.'Accion").val( "ayer" ); $("#'.$modelo.'TurnosForm").submit()' ) ); ?></div>&nbsp;
            <?php echo "&nbsp;<b>Fecha:</b>" . $this->Form->dateTime( 'fecha', 'DMY', null, array( 'class' => array( 'class' => 'input-small' ), 'value' => array( 'day' => $dia, 'month' => $mes, 'year' => $ano ), 'empty' => false, 'monthNames' => array( 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' ) ) ); ?>
            <?php echo $this->Html->tag( 'a', 'Ir a hoy', array( 'onclick' => '$("#'.$modelo.'Accion").val( "hoy" ); $("#'.$modelo.'TurnosForm").submit();') ); ?>
            <?php echo $this->Form->end( array( 'label' => "Cambiar", 'div' => false, 'class' => 'btn btn-success' ) ); ?>
            &nbsp;
            <div class="btn-group">
                <?php  echo $this->Html->tag( 'a', 'Dia >', array( 'class' => 'btn','onclick' => '$("#'.$modelo.'Accion").val( "manana" ); $("#'.$modelo.'TurnosForm").submit();') );?>
                <?php  echo $this->Html->tag( 'a', 'Sem >>', array( 'class' => 'btn','onclick' => '$("#'.$modelo.'Accion").val( "sem" ); $("#'.$modelo.'TurnosForm").submit();' ) );?>
                <?php  echo $this->Html->tag( 'a', 'Mes >>', array( 'class' => 'btn', 'onclick' => '$("#'.$modelo.'Accion").val( "mes"  ); $("#'.$modelo.'TurnosForm").submit();') );?>
            </div>
            &nbsp;
            <?php if( !$hoy ) {
                echo $this->Html->tag( 'a', 'Ir a hoy', array( 'class' => 'btn', 'onclick' => '$("#'.$modelo.'Accion").val( "hoy"  ); $("#'.$modelo.'TurnosForm").submit();' ) );
            } ?>
   </fieldset>
</div>

<?php
echo $this->element( 'Turnos/reservar'    , array( 'redirect' => $modelo ) );
echo $this->element( 'Turnos/autorefresco', array( 'redirect' => $modelo ) );
echo $this->element( 'Turnos/cancelar'    , array( 'redirect' => $modelo ) );
echo $this->element( 'Turnos/sobreturno'  , array( 'redirect' => $modelo ) );
?>

<?php if( $hoy ) { ?>
<!----------------------------------------------------------------------------------------------------------->
<!--------------------------------- CANCELAR ---------------------------------------------------------------->
<div id="cancelar" style="display:none" class="alert alert-info">
    <button type="button" class="close" data-dismiss="seldia">&times;</button>
    <?php echo $this->Form->create( $modelo, array( 'action' => 'cancelar', 'id' => 'cancelar2' ) );
          echo $this->Form->input( 'quien', array( 'type' => 'hidden', 'value' => 'm' ) );
          echo $this->Form->input( 'id_turno', array( 'type' => 'hidden', 'value' => -1 ) ); // Para evitar problemas luego  ?>
    Seleccione por favor que desea cancelar:
    <div class="btn-group">
        <?php echo $this->Html->tag( 'a', 'Todos los turnos hasta el final del día', array( 'class' => 'btn btn-danger', 'onclick' => 'cancelarTurnos( \'dia\' )' ) );
              echo $this->Html->tag( 'a', 'Próximo turno', array( 'class' => 'btn btn-danger', 'onclick' => 'cancelarTurnos( \'proximo\' )' ) );
              echo $this->Html->tag( 'a', 'Cancelar', array( 'class' => 'btn btn-success', 'onclick' => '$("#cancelar").slideUp()' ) ); ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
<?php } ?>

<?php echo $this->fetch( 'content' );
