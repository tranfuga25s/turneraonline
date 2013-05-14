<br />
<?php 
echo $this->element( 'flash/error', array( 'message' => $this->Session->flash() ) ); 
echo $this->Html->link( 'Volver al inicio',
                        array( 'controller' => 'turnos', 'action' => 'verTurnos', $usuarioactual['id_usuario'] ),
                        array( 'class' => 'btn btn-success' ) ); 
?>
<br />
