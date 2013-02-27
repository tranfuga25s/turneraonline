 <?php 
/*
 * Pagination Recall CakePHP Component
 * Copyright (c) 2008 Matt Curry
 * www.PseudoCoder.com
 *
 * @author      mattc <matt@pseudocoder.com>
 * @version     1.0
 * @license     MIT
 *
 */
 
 App::uses( 'Component', 'Controller' );

class PaginationRecallComponent extends Component {
  var $components = array('Session');
  var $Controller = null;

  function startup( &$controller ) {
    $this->Controller = & $controller;

    $options = $this->Controller->request->params['named'];

    $vars = array('page', 'sort', 'direction');
    $keys = array_keys($options);
    $count = count($keys);
    
    for ($i = 0; $i < $count; $i++) {
      if (!in_array($keys[$i], $vars)) {
        unset($options[$keys[$i]]);
      }
    }
    
    //save the options into the session
    if ($options) {
      if ($this->Session->check("Pagination.".$this->Controller->modelClass.".options")) {
        $options = array_merge($this->Session->read("Pagination.".$this->Controller->modelClass.".options"), $options);
      }
      
      $this->Session->write("Pagination.".$this->Controller->modelClass.".options", $options);
    }

    //recall previous options
    if ($this->Session->check("Pagination.".$this->Controller->modelClass.".options")) {
      $options = $this->Session->read("Pagination.".$this->Controller->modelClass.".options");
      $this->Controller->params['named'] = array_merge($this->Controller->params['named'], $options);
    }
  }
}