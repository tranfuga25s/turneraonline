<?php
echo $this->Html->css('/acl/css/acl.css');
?>
<div id="plugin_acl">
	
	<?php echo $this->Session->flash('plugin_acl'); ?>
	<h1><?php echo __d('acl', 'ACL plugin'); ?></h1>
	<?php

	if(!isset($no_acl_links))
	{
	    $selected = isset($selected) ? $selected : $this->params['controller'];
    
        $links = array();
        $links[] = $this->Html->link(__d('acl', 'Permissions'), array( 'controller' => 'aros', 'action' => 'index', 'plugin' => 'acl' ), array('class' => ($selected == 'aros' )? 'selected' : null));
        $links[] = $this->Html->link(__d('acl', 'Actions'), array( 'controller' => 'acos', 'action' => 'index', 'plugin' => 'acl' ), array('class' => ($selected == 'acos' )? 'selected' : null));
        
        echo $this->Html->nestedList($links, array('class' => 'acl_links'));
	}
	?>