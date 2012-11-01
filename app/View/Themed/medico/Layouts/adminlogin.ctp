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
		echo $this->Html->css( 'admin' );
		echo $this->Html->css( 'login' );
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
        <!-- Logo -->
        <div class="logo"> 
            <?php echo $this->Html->image( 'cabecera.png', array( 'alt' => 'Panel de control', 'style' => 'float: left; position: relative; top: -10px;' ) ); ?>
            <div id="slogan" style="color: white; padding-top: 10px;">
                <span style="font-size: 200%; font-weight: bolder;">Sistema de turnos online</span>
            </div>
		</div>            
                    
        <!-- Background wrapper -->
        <div id="box">
	        <?php echo $this->Session->flash(); ?><?php echo $this->Session->flash( 'auth' ); ?>
            <?php echo $content_for_layout; ?>
        <!-- End of bgwrap -->
        </div>      
  </body>
</html>