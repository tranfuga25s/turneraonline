<?php


class CalendarHelper extends AppHelper{
    var $helpers = array('Html');


    /**
     *
     * @var string strftime format for the day abbreviation.  Used in column headers
     */
    public $day_abbreviation_format = '%a';
    /**
     *
     * @var string tag to be used to contain the day within the table cell
     */
    public $day_tag = 'span';
    /**
     *
     * @var string name of the class that contains the day
     */
    public $day_class = 'day';
    /**
     *
     * @var string class to append to the cell if displayed day is today
     */
    public $today_day_class = 'today';
    /**
     *
     * @var string class to append to td cell if there is no date to show 
     */
    public $empty_day_class = 'empty-day';
    /**
     *
     * @var string class to append to td cell if that day is the selected day by named params
     */
    public $selected_class = 'selected';

    /**
     *
     * @var string class of prev / next month displayed in header
     */
    public $next_prev_month_class = 'next-prev-month';

    /**
     *
     * @var string tag to contain individual pieces of content injected into each day
     */
    public $day_content_tag = 'div';

    /**
     *
     * @var string class name to use in day_content_tag
     */
    public $day_content_class = 'day-content';

    /**
     * @var string class name of the calendar container
     */
    public $container_class = 'calendar';

    /**
     *
     * @var string id of the calendar container
     */
    public $container_id = null;

    /**
     * @var string id of calendar navigation or current month / year label
     */
    public $top_navigation_id = 'calendar-navigation';


    /**
     *
     * @var array CakePHP Router::url() friendly location of the ajax calendar navigation handler
     */
    public $ajax_calendar_url = array('controller' => 'calendars','plugin' => 'calendar','action' => 'navigate');

  

/**
     * Builds a calendar
     *
     * @param array $options Array containing the following indeces:
     *  month (int)
     *  year(int)
     *  next_prev_count (int)  number of months to show to the left and right for navigation
     *  events array - year / month / day indexed, the index should represent the month => day in which you want the content appended
     *          (ex) For the month of June, in 2010 array( 2010 => array(06 => array(1 => 'Partridge in a pear tree', 5 => 'Golden Rings')))
     * @return string output of an HTML calendar
     * @access public
     */
    function draw($options = array()){
    	$options = $this->_setDefaults($options);


        //What day is today? int value with no leading 0s
        $today = date('d');
        //what's the first day of this month?
        $first_day = date('w',mktime(0,0,0,$options['month'],1,$options['year']));
        //how many days are in this month?
        $days_in_month = date("t",mktime(0,0,0,$options['month'],1,$options['year']));
        //how long are we looping?
        $weeks_in_month = ceil(($first_day + $days_in_month) / 7);
        $day_counter = 1;


        //Main content var to be returned
        $calendar_content = '';

        $view =& ClassRegistry::getObject('view');

        //We will start by building out the year and month header 


        //hold top nav or just month/year label of calendar being shown
        $calendar_top_navigation = '';
        //Any "previous" month navigations we wanna show?
        for($x=(0-$options['prev_count']);$x < 0;$x++){
            $month_year = $this->__getYearAndMonth($options['month'],$options['year'],$x);
            //@TODO place these in separate element as a step towards putting more items in the calendar as re-usable and easier to manage display elements

            $prev_month_link = array_merge($this->params['named'],$month_year);
            if($options['ajax']){
                $prev_month_link = array_merge($this->ajax_calendar_url,$prev_month_link);
            }
            $calendar_top_navigation .= $this->Html->tag('span',$this->Html->link(strftime('%b',mktime(0,0,0,$month_year['month'],1,$month_year['year'])),
	                '#'/*$prev_month_link*/,
	                array(
	                    'title' => 'Mes anterior',
	                    'id' => 'previous-month',
                            'class' => $this->next_prev_month_class,
			    'onclick' => 'cargarCalendario( '.$month_year['month'].', '.$month_year['year'].' )'
	            )));
            

        }
	setlocale(LC_TIME, "es_AR");
        //Show the current month / year in between previous and next months
        $calendar_top_navigation .= $this->Html->tag( 'span', strftime( '%B', mktime( 0, 0, 0, $options['month'], 1, $options['year'] ) ), array( 'id' => 'calendar-month' ) );
        $calendar_top_navigation .= $this->Html->tag( 'span', strftime( '%Y', mktime( 0, 0, 0, $options['month'], 1, $options['year'] ) ), array( 'id' => 'calendar-year' ) );

        //Next Months
        for($x=0;$x<$options['next_count'];$x++){
            $month_year = $this->__getYearAndMonth($options['month'],$options['year'],$x+1);

            $next_month_link = array_merge($this->params['named'],$month_year);
            if($options['ajax']){
                $next_month_link = array_merge($this->ajax_calendar_url,$next_month_link);
            }
            $calendar_top_navigation .=  $this->Html->tag('span',$this->Html->link(strftime('%b',mktime(0,0,0,$month_year['month'],1,$month_year['year'])),
			'#',
	                array(
	                    'title' => 'Proximo mes',
	                    'id' => 'next-month',
                            'class' => $this->next_prev_month_class,
			    'onclick' => 'cargarCalendario( '.$month_year['month'].', '.$month_year['year'].' )'
	            )));
        }
        //$calendar_top_navigation .= $this->Html->div('calendar-clear','&nbsp;');

        $calendar_content .= $this->Html->tag('div',$calendar_top_navigation,array('id' => $this->top_navigation_id));
        $days_of_week = $this->days_of_week();
        $calendar_table_header = $this->Html->tableHeaders($days_of_week);

        $table_rows = array();
	       

        /* A little explanation of variables here
         *
         * $cur_day holds the int value of the day
         * $full_day holds the 2 character string of the day
         * $display_day_value holds the value to be output in the cell of the day, which could be a link or it could be just the cur_day
         *
         * @TODO more clever way to split $full_day and $cur_day as they can both be referenced, one is used for display,
         *  and could be done without having separate vars, as we already have a display_day_value
         *
         */
        for($x=0;$x<$weeks_in_month;$x++){
            $table_cells = array();
            for($y=0;$y<7;$y++){
                $cur_day = $full_day = $day_counter - $first_day;
                $full_day = (string) $full_day;
                if( ($cur_day >= 1)  && ($cur_day <= $days_in_month)){

                    if($options['show_day_link'] == true){
                        $options['link_template']['day'] = $cur_day;
			if( in_array( $cur_day,  $options['events'][$options['year']][intval($options['month'])] ) ) {
				$display_day_value = $this->Html->link( $cur_day, '#'/*$options['link_template']*/, array( 'onClick' => 'cargarTurnos( '.$options['year'].', '.$options['month'].', '.$cur_day.' )' ) );
			} else {
				$display_day_value = $cur_day;
			}
                        
                    }else{
                            $display_day_value = $cur_day;
                    }

                }else{//this day is not in the month, so we show nothing @TODO show last month or next month "hints"?
                    $display_day_value = " ";
                }

                if(strlen($full_day) == 1){
                    $full_day = '0'.$full_day;
                }
                $td_class_name = '';
                if($today == $cur_day && $options['month'] == date('m') && $options['year'] == date('Y')){
                    $td_class_name = $this->today_day_class;
                }elseif(isset($this->params['named']['day']) && $cur_day == $this->params['named']['day']){
                    $td_class_name = $this->selected_day_class;
                }elseif($display_day_value == " "){
                    $td_class_name = $this->empty_day_class;
                } 
		if( array_search( $cur_day,  $options['events'][$options['year']][intval($options['month'])] ) != FALSE ) {
	 	    $td_class_name = 'disponible';
		}

                $cell_content = $this->Html->tag( 'span', $display_day_value, array( 'class' => $this->day_class ) );

       
                if(isset($this->content[$options['year']][$options['month']][$full_day])){
                    
                    foreach($this->content[$options['year']][$options['month']][$full_day] as $day_content){
                        $cell_content .=  $this->Html->tag($this->day_content_tag,$day_content,array('class' => $this->day_content_class));
                    }

                }
		if( $td_class_name == '' ) {
			$table_cells[] = array( $cell_content, array() );
		} else {
                	$table_cells[] = array( $cell_content, array( 'class' => $td_class_name ) );
		}
                
                $day_counter++;
            }//End loop -- days this week
            $table_rows[] = $table_cells;
        }//End loop -- weeks in month
        
        $calendar_table_cells = $this->Html->tableCells($table_rows);
        $calendar_content .= $this->Html->tag('table',$calendar_table_header . $calendar_table_cells, array( 'cellspacing' => 0, 'id' => "tablacalendario" ) );
        $calendar_content = $this->Html->tag('div',$calendar_content,array('class' => $this->container_class,'id' => $this->container_id));

        if($options['ajax']){
            $engine = false;
            if($options['ajax'] === true){
                $engine = 'jquery';
            }elseif(is_string($options['ajax'])){
                $engine = $options['ajax'];
            }

            if($engine){
                $this->Html->script('/calendar/js/calendar.'.$engine.'.js',array('inline' => false));
            }
        }
        return $calendar_content;
    }



    private function __getYearAndMonth($month,$year,$monthIteration = 0){
        $month += $monthIteration;
        $monthYearArray = array(
            'month' => $month,
            'year' => $year
        );
        if($month < 1){
            $monthYearArray['month']+= 12;
            $monthYearArray['year']--;
        }elseif($month > 12){
            $monthYearArray['month'] -= 12;
            $monthYearArray['year']++;
        }
        if(strlen($monthYearArray['month'])< 2) $monthYearArray['month'] = '0'.$monthYearArray['month'];

        return $monthYearArray;
    }


    private function _setDefaults($options){
        if(!isset($options['month']) || empty($options['month'])){
            if(isset($this->params['named']['month'])){
                $options['month'] = $this->params['named']['month'];
            }else{
                $options['month'] = date('m');
            }

            if(strlen($options['month'])< 2) $options['month'] = '0'.$options['month'];

        }
        if(!isset($options['month']) || empty($options['year'])){
            if(isset($this->params['named']['year'])){
                $options['year'] = $this->params['named']['year'];
                if(strlen($options['year']  == 2) ) $options['year'] = '20'.$options['year'];
            }else{
                $options['year'] = date('Y');
            }

        }
        
        $options = array_merge(array('ajax' => false,'next_prev_count' => 2,'link_template' => array('month' => $options['month'],'year' => $options['year']),'show_day_link' => true),$options);


        /** If the events are passed into the options */
        /*if(isset($options['events']) && is_array($options['events'])){
            foreach($options['events'] as $year => $months){
                foreach($months as $month => $days){
                    foreach($days as $day => $content){
                        $this->event($year.'-'.$month.'-'.$day,$content);
                    }
                }
            }
            unset($options['content']);
        }*/

        return $options;
    }


    /**
     * @param string any valid date recognized by strtotime
     * @param string|array content to be placed into the table cell
     * @return boolean 
     */
    public function event($date, $content = ''){

        if(is_array($date)){
            foreach($date as $d => $content){
                
                $this->event($d,$content);
            }
        }else{
            if(is_string($date) && !strtotime($date)) return false;

            if(is_numeric($date) && !date('Y',$date)) return false;
            
            $time = is_string($date) ? strtotime($date) : $date;
            $year = date('Y',$time);
            $month = date('m',$time);
            $day = date('d',$time);
            if(!isset($this->content[$year][$month][$day])){
                $this->content[$year][$month][$day] = array();
            }
            if(is_array($content)){
                foreach($content as $c){
                    $this->content[$year][$month][$day][] = $c;
                }
            }else{
                $this->content[$year][$month][$day][] = $content;
            }
        }
        
        
        return true;
    }

    public function days_of_week(){
        /*$beginning = strtotime('Last Sunday');
        return array(
           strftime($this->day_abbreviation_format, $beginning),
           strftime($this->day_abbreviation_format, $beginning += 86400),
           strftime($this->day_abbreviation_format, $beginning += 86400),
           strftime($this->day_abbreviation_format, $beginning += 86400),
           strftime($this->day_abbreviation_format, $beginning += 86400),
           strftime($this->day_abbreviation_format, $beginning += 86400),
           strftime($this->day_abbreviation_format, $beginning += 86400),
        );*/
        return array(
           'Dom',
           'Lun',
           'Mar',
           'Mie',
           'Jue',
           'Vie',
           'Sab',
        );
    }

}
?>