<?php 
echo $this->Form->create( 'Turno', array( 'action' => 'nuevo' ) );
echo $this->Form->input( 'paso', array( 'type' => 'hidden', 'value' => $paso ) );
echo $this->Form->input( 'id_turno', array( 'type' => 'hidden', 'value' => -1 ) );
echo $this->Form->input( 'id_paciente', array( 'type' => 'hidden', 'value' => $usuarioactual['id_usuario'] ) );
?>
<fieldset>
    <legend>Seleccione un horario a su conveniencia de los disponibles</legend>
    <p>El horario disponible se encuentra marcado con verde</p>
    <!-- horarios -->
    <?php //debug( $turnos ); ?>
    <table class="table table-hover table-bordered">
        <tbody>
            <tr>
                <th colspan="2">Horario</th>
                <th rowspan="2">Consultorio</th>
                <th rowspan="2">&nbsp;</th>
            </tr>             
            <tr>
                <th>Inicio</th>
                <th>Fin</th>
            </tr>   
            <?php
            $celdas = array(); 
            foreach( $turnos as $turno ) {
                $celdas[] = array(
                    $turno['Turno']['hora'].':'.$turno['Turno']['minuto'],
                    $turno['Turno']['horaf'].':'.$turno['Turno']['minutof'],
                    $turno['Consultorio']['nombre'],
                    $this->Html->link(  'Reservar', 
                                        '#', 
                                        array( 'onclick' => "enviarReserva( ".$turno['Turno']['id_turno'].", \"".$turno['Turno']['hora'].':'.$turno['Turno']['minuto']."\" );",
                                               'class'   => 'btn btn-success' ) )
                );
            }
            echo $this->Html->tableCells( $celdas ); ?>
        </tbody>
    </table>
</fieldset>

<script type="text/javascript">
<?php if( isset( $nombre_fecha ) ) : ?>
    $("#fecha").html( '<?php echo $nombre_fecha; ?>' );
<?php endif; ?>

function enviarReserva( id_turno, horario ) {
    // Actualizo el valor del formulario
    $("#TurnoIdTurno").attr( 'value', id_turno );
    
    $("#hora").html( horario );
    
    $.ajax( { async: false,
              data: $("#TurnoNuevoForm").serialize(),
              evalScripts: true,
              type: "post",
              format: 'json',
              url: '<?php echo Router::url( array( 'action' => 'cargarDatos' ) ); ?>',
              success: function ( datos ) {
                $("#cambiar").html( datos );
              },
              error: function() {
                alert( 'No se pudo cargar los datos de el calendario. Existió un error.\n Intente nuevamente más tarde' ); 
             }
        } );
}
</script>
<?php echo $this->Form->end(); ?>