<?php
/****
 * Listado de personal del sitio
 * @author Esteban Zeller
 */
 
 $medicos = $this->requestAction( array( 'controller' => 'medicos', 'action' => 'index' ) );
 $secretarias = $this->requestAction( array( 'controller' => 'secretarias', 'action' => 'index' ) );
 $this->set( 'title_for_layout', "Nuestro personal" );
 ?>
 <h2>Nuestro personal</h2>
 <h3>Dentistas</h3>
 <?php foreach( $medicos as $medico ): ?>
 <div>
 	<h4><?php echo h( $medico['Usuario']['razonsocial'] ); ?></h4>
 	<b>bla</b>
 </div>
 <?php endforeach; ?>
 <h3>Secretarias</h3>
 <?php foreach( $secretarias as $secretaria ): ?>
 <div>
 	<h4><?php echo h( $secretaria['Usuario']['razonsocial'] ); ?></h4>
 	<b>bla</b>
 </div>
 <?php endforeach; ?> 
