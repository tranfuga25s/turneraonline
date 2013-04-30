<?php
/**
 *
 * @author   Nicolas Rod <nico@alaxos.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.alaxos.ch
 */
class AclController extends AclAppController {

	var $name = 'Acl';
	var $uses = null;
	
	function index()
	{
	    $this->redirect( array( 'controller' => 'aros', 'plugin' => 'acl' ) );
//	    $this->redirect('/admin/acl/aros');
	}
	
	function admintracion_index()
	{
	    $this->redirect( array( 'controller' => 'acos', 'plugin' => 'acl' ) );
//	    $this->redirect('/admin/acl/acos');
	}
	
}
?>