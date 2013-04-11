<div id="acciones" class="span2">
	<ul class="nav nav-tabs nav-stacked">
		<li><?php echo $this->Html->link( 'Inicio', '/' ); ?></li>
		<li><?php echo $this->Html->link( 'Editar mis datos', array('controller' => 'usuarios', 'action' => 'edit', $usuario['Usuario']['id_usuario'])); ?></li>
		<li><?php echo $this->Html->link( 'Cambiar contraseña', array('controller' => 'usuarios', 'action' => 'cambiaContra', $usuario['Usuario']['id_usuario'])); ?></li>
		<li><?php echo $this->Html->link( 'Ver Obras sociales', array('controller' => 'obras_sociales', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link( 'Pedir turno', array( 'controller' => 'turnos', 'action' => 'nuevo' ) ); ?></li>
		<li><?php echo $this->Html->link( 'Ver mis turnos', array( 'controller' => 'turnos', 'action' => 'verTurnos', $usuario['Usuario']['id_usuario'] ) ); ?></li>
		<li><?php echo $this->Html->link( 'Salir', array('controller' => 'usuarios',  'action' => 'salir' ) ); ?></li>
	</ul>
</div>