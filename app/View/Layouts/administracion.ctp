<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title> <?php echo $title_for_layout; ?> :: Administracion :: Sistema de turnos online </title>
	<?php
		echo $this->Html->meta('icon');
		//echo $this->Html->css('cake.generic');
        echo $this->Html->css( 'layout' );
		echo $this->Html->css( 'smoothness/jquery-ui');
		echo $this->Html->script( 'jquery-1.7.2.min' );
		echo $this->Html->script( 'jquery-ui-1.8.20.custom.min' );
        echo $this->Html->script( 'easyTooltip' );
        echo $this->Html->script( 'jquery.wysiwyg' );
        echo $this->Html->script( 'hoverIntent' );
        echo $this->Html->script( 'superfish' );
        echo $this->Html->script( 'custom' );
		echo $this->Html->css( 'admin' );
		echo $scripts_for_layout;
	?>
</head>
<body>
    <script>
    $( function() {
        $("a","#acciones").button();
        $("a",".actions").button();
    });
    </script>
	<div id="container">
		<div id="header">
		        <!-- Top -->
                <div id="top">
                    <!-- Logo -->
                    <div class="logo"> 
                        <?php echo $this->Html->image( 'cabecera.png', array( 'alt' => 'Panel de control', 'style' => 'float: left; position: relative; top: 10px;' ) ); ?>
                        <div id="slogan" style="margin-top: 20px; color: white;">
                            <span style="font-size: 200%; font-weight: bolder;">Panel de control</span><br />
                            <span>Sistema de turnos online</span>
                        </div>
                    </div>
                    <!-- End of Logo -->
                    <!-- Meta information -->
                    <div class="meta">
                        <p>Bienvenido, <?php echo $usuarioactual['nombre'] . " " . $usuarioactual['apellido']; ?>!</p>
                        <ul>
                            <li><?php echo $this->Html->link( '<span class="ui-icon ui-icon-power"></span>Salir', array( 'controller' => 'usuarios', 'action' => 'salir', 'plugin' => false ), array( 'title' => "Cerrar sesion de administracion", 'class' => 'tooltip', 'escape' => false ) ); ?></li>
                            <li><?php echo $this->Html->link( '<span class="ui-icon ui-icon-wrench"></span>Preferencias', array( 'controller' => 'configuracion', 'action' => 'ver', 'plugin' => false ), array( 'title' => "Cambia las preferencias", 'class' => "tooltip", 'escape' => false ) ); ?></li>
                            <li><?php echo $this->Html->link( '<span class="ui-icon ui-icon-person"></span>Mis datos', array( 'controller' => 'usuarios', 'plugin' => false, 'action' => 'edit', $usuarioactual['id_usuario'] ), array( 'title' => "Ir a los datos de mi usuario", 'class' => 'tooltip', 'escape' => false ) ); ?></li>
                        </ul>   
                    </div>
                    <!-- End of Meta information -->
                </div>
                <!-- End of Top-->
                
                <!-- The navigation bar -->
                <div id="navbar">
                    <ul class="nav">
                        <li><?php echo $this->Html->link( 'Inicio', array( 'controller' => 'usuarios', 'action' => 'cpanel', 'plugin' => false ) ); ?></li>
                        <li><?php echo $this->Html->link( 'Usuarios', array( 'controller' => 'usuarios', 'action' => 'index', 'plugin' => false ) ); ?></li>
                        <li><?php echo $this->Html->link( 'Medicos', array( 'controller' => 'medicos', 'action' => 'index', 'plugin' => false ) ); ?></li>
                        <li><?php echo $this->Html->link( 'Secretarias', array( 'controller' => 'secretarias', 'action' => 'index', 'plugin' => false ) ); ?></li>
                        <li><?php echo $this->Html->link( 'Turnos', array( 'controller' => 'turnos', 'action' => 'index', 'plugin' => false ) ); ?></li>
                        <li><a href="#">Mas</a>
                            <ul>
                            	<li><?php echo $this->Html->link( 'Clinicas', array( 'controller' => 'clinicas', 'action' => 'index', 'plugin' => false  ) ); ?></li>
                                <li><?php echo $this->Html->link( 'Especialidades', array( 'controller' => 'especialidades', 'action' => 'index', 'plugin' => false  ) ); ?></li>
                                <li><?php echo $this->Html->link( 'Consultorios', array( 'controller' => 'consultorios', 'action' => 'index', 'plugin' => false ) ); ?></li>
                                <li><?php echo $this->Html->link( 'Obras Sociales', array( 'controller' => 'obras_sociales', 'action' => 'index', 'plugin' => false ) ); ?></li>
                                <li><a href="#">Sistema</a>
                                    <ul>
                                        <li><?php echo $this->Html->link( 'Grupos', array( 'controller' => 'grupos', 'action' => 'index', 'plugin' => false ) ); ?></li>
                                        <li><a href="#">Permisos</a></li>
                                        <li><?php echo $this->Html->link( 'Auditoria', array( 'plugin' => 'audit_log', 'controller' => 'audit_log', 'action' => 'index' ) ); ?></li>
                                    </ul>
                                </li>
                                <li><a href="#">Notificaciones</a></li>
                                <li><?php echo $this->Html->link( 'Configuracion', array( 'controller' => 'configuracion', 'action' => 'ver', 'plugin' => false ) ); ?></li>
                            </ul>
                        </li>
                        <li><?php echo $this->Html->link( 'Ver sitio', '/', array( 'target' => '_blank' ) ); ?></li>
                    </ul>
                </div>
                <!-- End of navigation bar" -->
		    </div>
            <!-- End of Header -->
            
                        
            <!-- Background wrapper -->
            <div id="bgwrap" style="margin-left: 15px;">
        
                <!-- Main Content -->
                <div id="content">
                    <div id="main">
                        <?php echo $this->Session->flash(); ?><?php echo $this->Session->flash( 'auth' ); ?>
                        <?php echo $content_for_layout; ?>
                    <hr />
                </div>
                <!-- End Main content -->               
            </div>
            <!-- End of bgwrap -->
        </div>
        <!-- End of Container -->
        <div class="publicidad">
			<script type="text/javascript"><!--
			google_ad_client = "ca-pub-1880233918301202";
			/* Desarrollo */
			google_ad_slot = "0058508055";
			google_ad_width = 468;
			google_ad_height = 60;
			//-->
			</script>
			<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
		</div>
		<?php echo $this->element('devoluciones'); ?>
        <!-- Footer -->
        <div id="footer">
            <p class="mid">
            <div style="float: left; margin-left: 12px; color: white;"><?php echo $_SERVER['SERVER_NAME']; ?> &copy; 2012</div>
            <div style="float: right;">
            <?php   echo $this->Html->link(
                    $this->Html->image('cake.power.gif', array( 'alt' => "CakePHP", 'border' => 0 ) ),
                    'http://www.cakephp.org/',
                    array( 'target' => '_blank', 'escape' => false )
                );
                  echo "&nbsp; &nbsp;";
                  echo $this->Html->link( 
                    $this->Html->image( 'bslogo.png', array( 'alt' => 'BSComputacion', 'border' => 0 ) ),
                    'http://www.bscomputacion.com.ar',
                    array( 'target' => '_blank', 'escape' => false  ) );
                  echo "&nbsp; &nbsp;";
                  echo $this->Html->link(
                    $this->Html->image( 'tr.logo.png', array( 'alt' => "TR Sistemas Informaticos Integrados", 'border' => '0' ) ),
                    'http://www.bscomputacion.org/',
                    array( 'target' => '_blank', 'escape' => false )
                );
            ?></div>    
            </p>
        </div>
        <!-- End of Footer -->
        <?php echo $this->element('sql_dump'); ?>
  </body>
</html>