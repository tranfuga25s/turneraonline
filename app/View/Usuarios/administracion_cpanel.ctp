<!-- Panel de administración -->
<?php $this->set( 'title_for_layout', 'Panel de control' ); ?>
<h1>Bienvenido, <span><?php echo $usuarioactual['nombre']; ?></span>!</h1>
<p>Que desea hacer hoy?</p>
<h2>Datos</h2>
<ul class="dash">
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/clinic_icon.gif' ) 
                .'<span>Clinicas</span>',
                array( 'controller' => 'clinicas', 'action' => 'index', 'plugin' => false ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Clinicas' ) ); ?></li>
   <li><?php echo $this->Html->link(
                $this->Html->image( 'cabecera.png' ) 
                .'<span>Especialidades</span>',
                array( 'controller' => 'especialidades', 'action' => 'index', 'plugin' => false ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Especialidades' ) ); ?></li>                    
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/icono-consultorio.png' ) 
                .'<span>Consultorios</span>',
                array( 'controller' => 'consultorios', 'action' => 'index', 'plugin' => false ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Consultorios' ) ); ?></li>
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/medic-icon.png' ) 
                .'<span>Medicos</span>',
                array( 'controller' => 'medicos', 'action' => 'index', 'plugin' => false ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Medicos' ) ); ?></li>
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/secretary-icon.gif' ) 
                .'<span>Secretarias</span>',
                array( 'controller' => 'Secretarias', 'action' => 'index', 'plugin' => false ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Secretarias' ) ); ?></li>
   <li><?php echo $this->Html->link(
                $this->Html->image( 'cabecera.png' ) 
                .'<span>Obras Sociales</span>',
                array( 'controller' => 'obras_sociales', 'action' => 'index', 'plugin' => false ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Obras Sociales' ) ); ?></li>
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/icon_calendar2.gif' ) 
                .'<span>Turnos</span>',
                array( 'controller' => 'turnos', 'action' => 'index', 'plugin' => false ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Listado de turnos' ) ); ?></li>
</ul>
<h2>Sistema</h2>
<ul class="dash">
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/icons/16_48x48.png' ) 
                .'<span>Usuarios</span>',
                array( 'controller' => 'usuarios', 'action' => 'index', 'plugin' => false ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Usuarios' ) ); ?></li>
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/user_group-icon.gif' ) 
                .'<span>Grupos</span>',
                array( 'controller' => 'grupos', 'action' => 'index', 'plugin' => false ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Grupos' ) ); ?></li>
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/icons/5_48x48.png' ) 
                .'<span>Permisos</span>',
                array( 'plugin' => 'acl', 'controller' => 'acos'),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Permisos del sistema' ) ); ?></li>
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/icons/14_48x48.png' ) 
                .'<span>Estadisticas</span>',
                array( 'controller' => 'estadisticas', 'action' => 'index', 'plugin' => false ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Visor de estadisticas' ) ); ?></li>
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/icons/4_48x48.png' ) 
                .'<span>Mi cuenta</span>',
                array( 'plugin' => 'gestotux', 'controller' => 'gestotux', 'action' => 'index' ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Ver cuenta corriente' ) ); ?></li>
</ul>
<h2>Configuraci&oacute;n</h2>
<ul class="dash">
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/notification-icon.png' ) 
                .'<span>Notificaciones</span>',
                '#',
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Todavía no implementado' ) ); ?></li>
   <li>	<?php echo $this->Html->link( 
   				$this->Html->image( 'cabecera.png' )
   				.'<span>Auditoria</span>',
   			     array( 'plugin' => 'audit_log', 'controller' => 'audit_log', 'action' => 'index' ),
   			     array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Acciones realizadas en el sistema' ) ); ?></li>                
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/configuration-icon.png' ) 
                .'<span>Configuracion</span>',
                array( 'controller' => 'configuracion', 'action' => 'ver', 'plugin' => false ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Configuración' ) ); ?></li>
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/icons/25_48x48.png' ) 
                .'<span>Ver sitio</span>',
                '/', array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Volver al sitio', 'target' => '_blank' ) ); ?></li>

</ul>