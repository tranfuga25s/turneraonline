<div id="acciones" class="span2">
	<ul class="nav nav-tabs nav-stacked">
		<li><?php echo $this->Html->link( '<i class="icon-home"></i> Inicio', '/', array( 'escape' => false ) ); ?></li>
		<li><?php echo $this->Html->link( '<i class="icon-pencil"></i> Editar mis datos', array('controller' => 'usuarios', 'action' => 'edit', $usuarioactual['id_usuario']), array( 'escape' => false ) ); ?></li>
		<li><?php echo $this->Html->link( '<i class="icon-asterisk"></i> Cambiar contraseña', array('controller' => 'usuarios', 'action' => 'cambiarContra', $usuarioactual['id_usuario']), array( 'escape' => false ) ); ?></li>
		<li><?php echo $this->Html->link( '<i class="icon-eye-open"></i> Ver Obras sociales', array('controller' => 'obras_sociales', 'action' => 'index'), array( 'escape' => false ) ); ?></li>
		<li><?php echo $this->Html->link( '<i class="icon-calendar"></i> Pedir turno', array( 'controller' => 'turnos', 'action' => 'nuevo' ), array( 'escape' => false )  ); ?></li>
		<li><?php echo $this->Html->link( '<i class="icon-list-alt"></i> Ver mis turnos', array( 'controller' => 'turnos', 'action' => 'verTurnos', $usuarioactual['id_usuario'] ), array( 'escape' => false )  ); ?></li>
		<li><?php echo $this->Html->link( '<i class="icon-off"></i> Salir', array('controller' => 'usuarios',  'action' => 'salir' ), array( 'escape' => false )  ); ?></li>
	</ul>
</div>