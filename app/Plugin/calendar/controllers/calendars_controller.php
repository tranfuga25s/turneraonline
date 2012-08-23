<?php

class CalendarsController extends AppController{

    public $uses = array();

    public $components = array('RequestHandler');//use Cake's core RequestHandler component to ensure this is an ajax call, and not a requestAction()


    /**
     * Ajax call for the dashboard calendar
     */
    function navigate(){
        $view = new View($this);
        $loaded = array();
        $helpers = $view->_loadHelpers($loaded, array('Calendar.Calendar'), $parent = null);

        /* If you have any events that you want to add into your calendar prior to drawing it, you may do so here */

        ob_start();
        echo $helpers['Calendar']->draw();
        $calendarContent = ob_get_clean();
        
        if(!empty($this->params['requested'])){
            return $calendarContent;
        }elseif($this->RequestHandler->isAjax()){
            header('Content-type:application/json');
            die(json_encode(array('calendar' => $calendarContent)));
        }        
    }

}