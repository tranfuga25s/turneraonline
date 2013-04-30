<div id="aros_link" class="acl_links">
<?php
$selected = isset($selected) ? $selected : $this->params['action'];

$links = array();
$links[] = $this->Html->link(__d('acl', 'Build missing AROs'), array( 'plugin' => 'acl', 'controller' => 'aros', 'action' => 'check' ), array('class' => ($selected == 'admin_check' )? 'selected' : null));
$links[] = $this->Html->link(__d('acl', 'Users roles'), array( 'plugin' => 'acl', 'controller' => 'aros', 'action' => 'users' ), array('class' => ($selected == 'admin_users' )? 'selected' : null));

if(Configure :: read('acl.gui.roles_permissions.ajax') === true)
{
    $links[] = $this->Html->link(__d('acl', 'Roles permissions'), array( 'plugin' => 'acl', 'controller' => 'aros', 'action' => 'ajax_role_permissions' ), array('class' => ($selected == 'admin_role_permissions' || $selected == 'admin_ajax_role_permissions' )? 'selected' : null));
}
else
{
    $links[] = $this->Html->link(__d('acl', 'Roles permissions'), array( 'plugin' => 'acl', 'controller' => 'aros', 'action' => 'role_permissions' ), array('class' => ($selected == 'admin_role_permissions' || $selected == 'admin_ajax_role_permissions' )? 'selected' : null));
}
$links[] = $this->Html->link(__d('acl', 'Users permissions'), array( 'plugin' => 'acl', 'controller' => 'aros', 'action' => 'user_permissions' ), array('class' => ($selected == 'admin_user_permissions' )? 'selected' : null));

echo $this->Html->nestedList($links, array('class' => 'acl_links'));
?>
</div>