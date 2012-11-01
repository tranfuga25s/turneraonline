<!-- Listado de especialidades para la pagina inicial -->
<table border="0">
 <tbody>
  <tr>
  <?php foreach( $especialidades as $especialidad ) { ?>
	<!--<td><?php echo $this->Html->link( $especialidad['Especialidad']['nombre'], array( 'controller' => 'clinica', 'action' => 'view', 'id_clinica' => $clinica['Clinica']['id_clinica'] ) ); ?></td> -->
	<td><?php echo $especialidad['Especialidad']['nombre']; ?></td>
  <?php } ?>
  </tr>
 </tbody>
</table>