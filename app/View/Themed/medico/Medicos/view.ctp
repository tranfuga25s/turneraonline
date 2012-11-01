<?php 
$dias = array( 0 => 'domingo', 1 => 'lunes', 2 => 'martes', 3 => 'miercoles', 4 => 'jueves', 5 => 'viernes', 6 => 'sabado' );
$this->set( 'title_for_layout', "Datos del médico" ); 
?>
<script>
	$( function() {
		$('#acordion1').accordion( { autoHeight: false, navigation: true } );
		$('#acordion2').accordion( { autoHeight: false, navigation: true } );
		$('a', "#acciones" ).button();
	});
</script>
<div class="decorado1">
	<div class="titulo1">Datos del m&eacute;dico <?php echo $medico['Usuario']['razonsocial']; ?></div>
	<table><tbody><tr><td id="acordion1">
		<h3><a href="#">Datos</a></h3>
		<div>
			<dl>
				<dt>Especialidad:</dt>
				<dd><?php echo $medico['Especialidad']['nombre']; ?></dd>
	
				<dt>Cl&iacute;nica:</dt>
				<dd><?php echo $medico['Clinica']['nombre']; ?></dd>
			</dl>
		</div>
		<h3><a href="#">Disponibilidad Horaria</a></h3>
		<div>
			El m&eacute;dico atiende durante los siguientes horarios:<br />
			<table>
				<tbody>
					<tr>
						<th>D&iacute;a</th>
						<th>Ma&ntilde;ana</th>
						<th>Tarde</th>
					</tr>
					<tr>
					<?php foreach( $medico['Disponibilidad']['DiaDisponibilidad'] as $dis ) {
							if( $dis['habilitado'] == 1) {
								echo "<tr><td><b>".$dias[$dis['dia']]."</b></td>";
								if( $dis['hora_inicio'] != "00:00:00" ) {
									echo "<td>".date( 'H:i', strtotime( $dis['hora_inicio'] ) )." a ".date( "H:i", strtotime( $dis['hora_fin'] ) )."</td>";
								} else {
									echo "<td>&nbsp;</td>";
								}
								if( $dis['hora_inicio_tarde'] != "00:00:00" ){
									echo "<td>".date( 'H:i', strtotime( $dis['hora_inicio_tarde'] ) )." a ".date( "H:i", strtotime( $dis['hora_fin_tarde'] ) )."</td>";
								} else {
									echo "<td>&nbsp;</td></tr>";
								}
							}
						  } ?>
		    	</tbody>
		    </table>
		</div>
   </td>
   <td id="acordion2" width="50%">
		<h3><a href="#">Acci&oacute;nes</a></h3>
		<div id="acciones" style="width: 150px; text-align: center;">
			<?php echo $this->Html->link( 'Sacar turno', array( 'controller' => 'turnos', 'action' => 'nuevo' ) );
			      echo $this->Html->link( 'Contactar', '/pages/contacto' ); 
			      echo $this->Html->link( 'Volver', array( 'controller' => 'turnos', 'verTurnos' ) ); ?>
		</div>
	</td></tr></tbody></table>
</div>