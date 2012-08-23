<!-- Listado de clinicas para la pagina inicial -->
<table border="0">
 <tbody>
  <tr>
  <?php foreach( $clinicas as $clinica ) { ?>
	<td width="20%">
		<?php
		if( !empty( $clinica['Clinica']['logo'] ) ) {
		echo $this->Html->link( 
			$this->Html->image( $clinica['Clinica']['logo'], array( 'border' => 0, 'alt' => $clinica['Clinica']['nombre'] ) ),
			array( 'controller' => 'clinicas', 'action' => 'view', $clinica['Clinica']['id_clinica'] ),
			array( 'escape' => false ) );
		echo "<br />";
		}
		echo $this->Html->link( $clinica['Clinica']['nombre'], array( 'controller' => 'clinicas', 'action' => 'view', $clinica['Clinica']['id_clinica'] ) );
		?>
	</td>
  <?php } ?>
  </tr>
 </tbody>
</table>