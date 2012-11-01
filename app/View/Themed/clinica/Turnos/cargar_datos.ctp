<?php
if( count( $clinicas ) > 1 ) {
$datos['clinicas'] = $this->Form->input( 'clinica',
			array( 	'options' => $clinicas, 
				'empty' => 'Elija una clinica', 
				'selected' => $id_clinica, 
				'label' => false, 
				'div' => false ) );
} else {
$datos['clinicas'] =  h( array_pop( $clinicas ) ).
			"<div style=\"display: none;\">".
			$this->Form->input( 'clinica',
			array( 	'options' => $clinicas, 
				'selected' => $id_clinica, 
				'label' => false, 
				'div' => false ) ).
			"</div><script> var global_clinica = 0; </script>";
}
$datos['especialidades'] = "<p>";
			foreach( $especialidades as $esp ) {
				$datos['especialidades'] .= $esp. '&nbsp;<br />';
			}
$datos['especialidades'] .= "</p>";
$datos['especialidades'] .= "<div style=\"display: none;\">";
$datos['especialidades'] .= $this->Form->input( 'especialidad',
			array( 	'options' => $especialidades,
			       	'empty' => 'Todas',
				'selected' => $id_especialidad,
				'label' => false, 
				'div' => false, array( 'id' => 'especialidad' ) )
			);
$datos['especialidades'] .= "</div><script> var global_especialidad = 0; </script>";
$datos['medicos'] = $this->Form->input( 'medico',
			array( 	'options' => $medicos, 
				'empty' => 'Cualquier médico', 
				'selected' => $id_medico, 
				'label' => false, 
				'div' => false  )
			);
$datos['medicos'] .= "<script> var global_medico = 0; </script>";
echo json_encode( $datos );
?>