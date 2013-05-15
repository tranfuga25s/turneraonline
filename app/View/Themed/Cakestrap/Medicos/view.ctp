<?php 
$dias = array( 0 => 'domingo', 1 => 'lunes', 2 => 'martes', 3 => 'miercoles', 4 => 'jueves', 5 => 'viernes', 6 => 'sabado' );
$this->set( 'title_for_layout', "Datos del médico" ); 
?>
<div class="row-fluid">
	<div class="span12">
		<h4>Datos del m&eacute;dico <?php echo $medico['Usuario']['razonsocial']; ?></h4>
	</div>
</div>
<div class="row-fluid">	
	<div class="span9">
		<dl class="dl-horizontal">
			<dt>Especialidad:</dt>
			<dd><?php echo $medico['Especialidad']['nombre']; ?></dd>
	
			<dt>Cl&iacute;nica:</dt>
			<dd><?php echo $medico['Clinica']['nombre']; ?></dd>
		</dl>

		<h4>Disponibilidad horaria</h4>
		<table class="table table-hover table-bordered	">
			<tbody>
				<tr class="success">
					<td>D&iacute;a</td>
					<td>Ma&ntilde;ana</td>
					<td>Tarde</td>
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
	
	<div class="span3 well">
		<h3><a href="#">Acci&oacute;nes</a></h3>
		<div>
			<?php echo $this->Html->link( 'Sacar turno', array( 'controller' => 'turnos', 'action' => 'nuevo' ), array( 'class' => 'btn btn-primary btn-block' ) );
			      echo $this->Html->link( 'Contactar', array( 'controller' => 'contacto', 'action' => 'formulario' ), array( 'class' => 'btn btn-info btn-block' ) ); 
			      echo $this->Html->link( 'Volver', '/', array( 'class' => 'btn  btn-inverse btn-block' ) ); ?>
		</div>
	</div>
</div>

<div class="row-fluid">

	<div class="span5 well">
		<?php echo $this->Facebook->like(); ?>
		<?php echo $this->Facebook->recommendations(); ?>
	</div>
	<div class="span7 well"><?php echo $this->Facebook->comments(); ?></div>
	
</div>