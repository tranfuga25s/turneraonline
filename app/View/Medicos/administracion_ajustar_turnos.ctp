<?php 

  $this->set( 'title_for_layout', "Ajuste de turnos" );

?>
<div id="dtcorrecto" title="Correcto" style="display: none;">
	EL turno fue cancelado correctamente!
</div>
<div id="dtincorrecto" title="Error" style="display: none;">
	No se pudo cancelar el turno:
	<div id="dtimensaje"></div>
</div>
<script language="JavaScript" type="text/javascript">
function cancelar( id_turno ) {
	// Pido los datos para actualizar el contenido
	$.ajax( { async: true,
		  data: { 'id_turno': id_turno },
		  evalScripts: true,
		  type: "post",
		  format: 'json',
		  url: "<?php echo Router::url( array( 'controller' => 'turnos', 'action' => 'cancelarAjax' ) ); ?>",
		  success: function ( datos, textoEstado ) {
			// Formato del array
			var ret = JSON.parse( datos );
			if( ret.estado == true ) {
				$( "#turno" + ret.id_turno ).slideUp( 'slow' ).empty();
				$( "#dtcorrecto").dialog({ buttons: { "Ok": function() { $(this).dialog("close"); } } } );
			} else {
				$("#dtimensaje").appendText( ret.mensaje );
				$("#dtincorrecto").dialog({ buttons: { "Ok": function() { $(this).dialog("close"); } } } );
			},
		  error: function() {
		  	$("#dtimensaje").appendText( "Error de comunicacion" );
			$("#dtincorrecto").dialog({ buttons: { "Ok": function() { $(this).dialog("close"); } } } );
		  }
	} );
}

function trasladar( id_turno ) {
	// Pido los datos para actualizar el contenido
	$.ajax( { async: true,
		  data: { 'id_turno': id_turno },
		  evalScripts: true,
		  type: "post",
		  format: 'json',
		  url: "<?php echo Router::url( array( 'controller' => 'turnos', 'action' => 'trasladar' ) ); ?>",
		  success: function ( datos, textoEstado ) {
			// Formato del array
			var ret = JSON.parse( datos );
			if( ret.estado == true ) {
				$("#turno" +ret.id_turno).slideUp( 'slow' ).empty();
			} else {
				alert( 'No se pudo cancelar el turno.'+ret.mensaje );
			},
		  error: function() {
			alert( 'No se pudo trasladar el turno.');
		  }
	} );
}

function conservar( id_turno ) {
	// No realizo accion alguna ya que no se modifica el turno
	$("#turno" +id_turno).slideUp( 'slow' ).empty();
}

function cancelarTodos( todos ) {
	// Hago todas las cancelaciones
	$.each( todos, function( idx, elm ) { cancelar( elm ); } );
}
</script>
<!-- Ajuste de turnos -->
<div class="decorado1 index">
<div class="titulo1">Ajuste de turnos</div>
<table>
 <tbody>
  <tr>
   <th>Fecha</th>
   <th>Hora</th>
   <th>Paciente</th>
   <th>Consultorio</th>
   <th>Acciones</th>
  </tr>
<?php
foreach( $turnos as $turno ) {
	//pr( $turno );
	echo "<div id=\"turno".$turno['Turno']['id_turno']."\">";
		echo "<tr>";
			echo "<td>". date( "d/m/Y", strtotime( $turno['Turno']['fecha_inicio'] ) )."</td>";
			echo "<td>". date( "H:i"  , strtotime( $turno['Turno']['fecha_inicio'] ) ) . "</td>";
			echo "<td>". $turno['Paciente']['apellido'] .", ". $turno['Paciente']['nombre'] . "</td>";
			echo "<td>". $turno['Consultorio']['nombre']."</td>";
			echo "<td class=\"actions\">".  $this->Html->tag( 'a', 'Cancelar',  array( 'onclic' => 'cancelar('.  $turno['Turno']['id_turno'].')') ). "&nbsp;".
							//$this->Html->tag( 'a', 'Trasladar', array( 'onclic' => 'trasladar(', $turno['Turno']['id_turno'].')' ) );
							$this->Html->tag( 'a', 'Conservar', array( 'onclic' => 'conservar(', $turno['Turno']['id_turno'].')' ) ) . "&nbsp;".
							$this->Html->tag( 'a', 'Cancelar', array( 'onclic' => 'cancelar('. $turno['Turno']['id_turno'].')' ) );
							
			echo "</td>";
		echo "</tr>";
	echo "</div>";
}
?>
 </tbody>
</table>
</div>
<div class="actions">
	<h3>Acciones</h3>
	<ul>
		<li><?php echo $this->Html->tag( 'a', 'Cancelar todos', array( 'onclick' => 'cancelarTodos('. $ids .')' ) ); ?></li>
		<li><?php echo $this->Html->link( 'Conservar todos', array( 'action' => 'index' ) ); ?></li>
	</ul>
</div>