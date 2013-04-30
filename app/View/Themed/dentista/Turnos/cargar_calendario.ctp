<?php
//echo $this->Html->css( 'calendar' );

echo $this->Calendar->draw(
	array( 	'month' => $mes,
		'year' => $ano,
		'events' => $turnos,
		'link_template' => '',
		'next_count' => $meses_siguientes,
		'prev_count' => $meses_anteriores,
		'show_day_link' => true,
		'ajax' => true )
);
?>