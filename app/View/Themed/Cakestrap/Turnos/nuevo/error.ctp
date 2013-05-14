<br />
<h3>No se pudo reservar el turno</h3>
<?php 
echo $this->element( 'flash/error', array( 'message' => $this->Session->flash() ) );
?>
<br />
<div class="btn-group">
<?php 
echo $this->Html->link( 'Volver al inicio',
                        array( 'controller' => 'turnos', 'action' => 'nuevo', $usuarioactual['id_usuario'] ),
                        array( 'class' => 'btn btn-success' ) ); 
echo $this->Html->link( 'Elegir otro día',
                        array( 'controller' => 'turnos', 'action' => 'nuevo', $usuarioactual['id_usuario'] ),
                        array( 'class' => 'btn btn-info' ) );
echo $this->Html->link( 'Ver mis turnos',
                        array( 'controller' => 'turnos', 'action' => 'verTurnos', $usuarioactual['id_usuario'] ),
                        array( 'class' => 'btn btn-inverse' ) );
echo $this->Html->link( 'Ir al inicio',
                        '/',
                        array( 'class' => 'btn btn-primary' ) );
?>
</div>
<br />
