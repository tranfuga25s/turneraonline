<?php $this->set( 'title_for_layout', "Lista de obras sociales disponibles" ); ?>
<script>
 $( function() {
	$("a","#botones").button();
 });
</script>
<style>
	.contenedor-os {
		width: 100%;
	}
	
	.contenedor-os div {
		margin: 2px 2px 2px 2px;
		border: 1px solid gray;
		display: inline-block;
		text-decoration: none;
		color: white;
		font-size: 15px;
		text-shadow: 1px 1px gray;
		border-radius: 4px;
		box-shadow: 2px 2px black;
	}
	
	.contenedor-os div img {
		border: none;
		height: 150px;
		width: 150px;
	}
</style>
<div id="botones">
	<?php echo $this->Html->link( 'Inicio', '/' );
		  echo $this->Html->link( 'Nuevo turno', array( 'controller' => 'turnos', 'action' => 'nuevo' ) );
		  echo $this->Html->link( 'Mis datos', array( 'controller' => 'usuarios', 'action' => 'view' ) ); 
		  echo $this->Html->link( 'Salir', array( 'controller' => 'usuarios', 'action' => 'salir' ) ); ?>
</div>
<br />
<div class="decorado1">
	<div class="titulo1">Listado de Obras Sociales Disponibles</div>
	<p>Estas son las obras sociales con las que trabajamos. Pulse sobre el logo para ver m&aacute;s datos.</p>
	<div class="contenedor-os">
		<?php foreach( $obrasSociales as $obraSocial ):
			if( is_null( $obraSocial['ObraSocial']['logo'] ) ) {
				echo $this->Html->link( 
						'<div>'.
						$this->Html->image( 'cabecera.png' ).'<br />'.
						h( $obraSocial['ObraSocial']['nombre'] )					
						.'</div>',
					  array( 'action' => 'view', $obraSocial['ObraSocial']['id_obra_social'] ),
					  array( 'escape' => false ) );				
			} else {
				echo $this->Html->link( 
						'<div>'.
						$this->Html->image( $obrasSocial['ObraSocial']['logo'] ).'<br />'.
						h($obrasSociale['ObraSocial']['nombre'])					
						.'</div>',
					  array( 'action' => 'view', $obrasSocial['ObraSocial']['id_obra_social'] ),
					  array( 'escape' => false ) );
			}
		   endforeach; ?>
	</div>
</div>