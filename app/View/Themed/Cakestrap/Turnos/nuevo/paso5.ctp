<?php 
echo $this->Form->create( 'Turno', array( 'action' => 'nuevo' ) );
echo $this->Form->input( 'paso', array( 'type' => 'hidden', 'value' => $paso ) );
echo $this->Form->input( 'id_clinica', array( 'type' => 'hidden', 'value' => $id_clinica ) );
echo $this->Form->input( 'id_especialidad', array( 'type' => 'hidden', 'value' => $id_especialidad ) );
echo $this->Form->input( 'id_medico', array( 'type' => 'hidden', 'value' => $id_medico ) );
echo $this->Form->input( 'dia', array( 'type' => 'hidden', 'value' => -1 ) );
echo $this->Form->input( 'mes', array( 'type' => 'hidden', 'value' => -1 ) );
echo $this->Form->input( 'ano', array( 'type' => 'hidden', 'value' => -1 ) );
?>
<fieldset>
	<legend>Seleccione un día</legend>
	<p>La cantidad de turnos disponibles en cada día se muestran dentro del ovalo gris</p>
	<!-- Calendario -->
	<?php 
	//debug( $turnos );
	echo $this->Calendar2->draw(
	array( 	'month' => $mes,
    		'year' => $ano,
    		'events' => $turnos,
    		'link_template' => '',
    		//'next_count' => $meses_siguientes,
    		'next_count' => 1,
    		//'prev_count' => $meses_anteriores,
    		'prev_count' => 1,
    		'show_day_link' => true,
    		'ajax' => true ) ); ?>
</fieldset>

<script type="text/javascript">
<?php if( isset( $nombre_especialidad ) ) : ?>
    $("#especialidad").html( '<?php echo $this->Html->link( $nombre_especialidad, array( 'controller' => 'especialidades', 'action' => 'view', $id_especialidad ), array( 'escape' => false ) ); ?>' );
<?php endif; ?>

function enviarDia( ano, mes, dia ) {
	// Actualizo el valor del formulario
	$("#TurnoDia").attr( 'value', dia );
	$("#TurnoMes").attr( 'value', mes );
	$("#TurnoAno").attr( 'value', ano );
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

<style>
.calendar {
    background-color: white;    
}

.calendar table {
}

.calendar table td {
    margin: 0px;
    padding: 8px;
    padding-top: 10px;
    vertical-align: middle;
    text-align: center;
    min-width: 70px;
}

.calendar table td.empty-day {
    background-color: #E3E3E3;
}

.calendar table td.day {
    font-size: 16px;
    text-shadow: 0px 1px;
}

td.day:hover {
    background-color: blue;
    
}

td.empty-day {
    background: none;
}

td.today {
    background-color: cyan;
}
</style>
<?php echo $this->element( 'sql_dump' ); ?>
