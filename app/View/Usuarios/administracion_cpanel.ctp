<!-- Panel de administración -->
<?php $this->set( 'title_for_layout', 'Panel de control' ); ?>
<h1>Bienvenido, <span><?php echo $usuarioactual['nombre']; ?></span>!</h1>
<p>Que desea hacer hoy?</p>
 <!-- Big buttons -->
<h2>Datos</h2>
<ul class="dash">
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/icons/8_48x48.png' ) 
                .'<span>Clinicas</span>',
                array( 'controller' => 'clinicas', 'action' => 'index' ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Clinicas' ) ); ?></li>
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/icons/8_48x48.png' ) 
                .'<span>Especialidades</span>',
                array( 'controller' => 'especialidades', 'action' => 'index' ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Especialidades' ) ); ?></li>                    
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/icons/8_48x48.png' ) 
                .'<span>Consultorios</span>',
                array( 'controller' => 'consultorios', 'action' => 'index' ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Consultorios' ) ); ?></li>
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/icons/8_48x48.png' ) 
                .'<span>Medicos</span>',
                array( 'controller' => 'medicos', 'action' => 'index' ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Medicos' ) ); ?></li>
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/icons/8_48x48.png' ) 
                .'<span>Secretarias</span>',
                array( 'controller' => 'Secretarias', 'action' => 'index' ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Secretarias' ) ); ?></li>
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/icons/8_48x48.png' ) 
                .'<span>Obras Sociales</span>',
                array( 'controller' => 'obras_sociales', 'action' => 'index' ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Obras Sociales' ) ); ?></li>
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/icons/8_48x48.png' ) 
                .'<span>Turnos</span>',
                array( 'controller' => 'turnos', 'action' => 'index' ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Obras Sociales' ) ); ?></li>
</ul>
<!-- End of Big buttons -->
<h2>Sistema</h2>
<ul class="dash">
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/icons/16_48x48.png' ) 
                .'<span>Usuarios</span>',
                array( 'controller' => 'usuarios', 'action' => 'index' ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Usuarios' ) ); ?></li>
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/icons/8_48x48.png' ) 
                .'<span>Grupos</span>',
                array( 'controller' => 'grupos', 'action' => 'index' ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Grupos' ) ); ?></li>
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/icons/5_48x48.png' ) 
                .'<span>Permisos</span>',
                '#', array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Todavía no implementado' ) ); ?></li>
   <li>&nbsp;</li>
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/icons/14_48x48.png' ) 
                .'<span>Estadisticas</span>',
                '#', array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Todavía no implementado' ) ); ?></li>
</ul>
<h2>Configuraci&oacute;n</h2>
<ul class="dash">
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/icons/8_48x48.png' ) 
                .'<span>Notificaciones</span>',
                '#',
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Notificaciones' ) ); ?></li>
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/icons/8_48x48.png' ) 
                .'<span>Configuracion</span>',
                array( 'controller' => 'configuracion', 'action' => 'ver' ),
                array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Configuracion' ) ); ?></li>
   <li><?php echo $this->Html->link(
                $this->Html->image( 'assets/icons/8_48x48.png' ) 
                .'<span>Ver sitio</span>',
                '/', array( 'escape' => false, 'class' => 'tooltip', 'title' => 'Volver al sitio', 'target' => '_blank' ) ); ?></li>
</ul>