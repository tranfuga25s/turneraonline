<!-- Pagina que muestra la ayuda del sistema -->
<script>
	$( function() {
		$("#acordion1").accordion( { collapsible: true  } );
		$("#acordion2").accordion( { active: false, collapsible: true } );
	} );
</script>
<div class="decorado1">
	<div class="titulo1"><b>Ayuda para el sistema</b></div>
	<div style="text-align: left;">
	Bienvenido a la ayuda!<br />
	Aqu&iacute; encontrar&aacute; los consejos necesarios para utilizar el sistema.
	<table>
		<tr>
			<td>
			<div id="acordion1">
				<h3><a href="#">Indice</a></h3>
				<div>
					<ul>
						<li><a onclick="$('#acordion1').accordion( 'option', 'active', 1 );">P&aacute;gina de inicio.</a></li>
						<li><a onclick="$('#acordion1').accordion( 'option', 'active', 2 );">Registrarse.</a></li>
						<li><a onclick="$('#acordion1').accordion( 'option', 'active', 3 );">Olvid&eacute; mi contrase&ntilde;a.</a></li>
						<li><a onclick="$('#acordion1').accordion( 'option', 'active', 4 );">Salir del sistema.</a></li>
						<li><a onclick="$('#acordion2').accordion( 'option', 'active', 0 );">Eliminar mi cuenta.</a></li>
						<br />
						<li><a onclick="$('#acordion2').accordion( 'option', 'active', 1 );">Solicitar un turno.</a></li>
						<li><a onclick="$('#acordion2').accordion( 'option', 'active', 2 );">Ver mis turnos reservados.</a></li>
						<li><a onclick="$('#acordion2').accordion( 'option', 'active', 3 );">Cancelar un turno reservado.</a></li>
						<br />
						<li><a onclick="$('#acordion2').accordion( 'option', 'active', 4 );">¿Cuales son las notificaciones que voy a recibir?</a></li>
						<br />
					</ul>
				</div>
		
				<h3><a href="#">Pagina de inicio</a></h3>
				<div>
					La página de inicio del sistema le mostrará las acciónes disponibles para realizar dentro del sistema.<br />
					Las acciónes que podrá realizar son:
					<ul>
						<li><a onclick="$('#acordion2').accordion( 'option', 'active', 1 );$('#acordion1').accordion( 'option', 'active', false );">Solicitar un turno</a></li>
						<li><a onclick="$('#acordion2').accordion( 'option', 'active', 2 );$('#acordion1').accordion( 'option', 'active', false );">Ver sus turnos</a></li>
						<li><a onclick="$('#acordion1').accordion( 'option', 'active', 4 );">Salir del sistema</a></li>
					</ul>
					<br />
					<a onclick="$('#acordion1').accordion( 'option', 'active', 0 );">Volver al indice.</a>
				</div>
				
				<h3><a href="#">Registrarse</a></h3>
				<div>
					Utilizando la opción de "Registrarse" de la pantalla inicial, podrá ingresar al formulario donde se le solicitarán los siguientes datos:
					<ul>
						<li><b>Correo electronico:</b> servirá para identificarlo en el sistema y para recibir las notificaciones que surjan de los turnos.</li>
						<li><b>Contraseña:</b>&nbsp; Le será de palabra clave para ingresar al sistema.</li>
						<li><b>Nombre y apellido:</b>&nbsp; Este dato se solicita para que los medicos y secretarias sepan que personas están registradas y puedan realizar las operaciónes mas facilmente.</li>
						<li><b>Telefonos:</b>&nbsp; Servirá para contactarlo en caso de cambios de ultima hora o cualquier otro aviso que se considere necesario.</li>
						<li><b>Notificaciones:</b>&nbsp; Si decide habilitarlas, recibiar un aviso por email en las siguientes circunstancias:
							<ul>
								<li>Luego de reservar un turno.</li>
								<li>12 horas antes de que un turno reservado esté por cumplirse.</li>
								<li>Si el médico cancela su turno.</li>
							</ul>
					</ul>
					<br />Todos los datos serán utilizados solamente por personal de la clinica y no se compartirán con ningún externo.
					<br />
					<a onclick="$('#acordion1').accordion( 'option', 'active', 0 );">Volver al indice.</a>
				</div>
				
				<h3><a href="#">Olvide mi contraseña</a></h3>
				<div>
					Para recuperar su contraseña deberá utilizar la opción <b>Olvidé mi contraseña</b> en la pantalla de inicio.<br />
					Al ingresar en esa opción se le solicitará la cuenta de correo con la que se dió de alta en el sistema.<br />
					<br />
					El sistema verificará que la dirección de correo electrónico se encuentre en nuestra base de datos y de encontrarse registrado mediante esa dirección el sistema enviará un email que contiene los datos de su ususario y una nueva contraseña generada automaticamente.<br />
					Para ingresar con su nueva contraseña copie desde el email la contraseña y pegelá en el formulario de la página inicial.<br />
					Para cambiar su contraseña, una vez que haya ingresado al sistema, ingrese a la opción "Mis datos".<br />
					Allí encontrará la opción "cambiar mi contraseña" donde podrá colocar una nueva contraseña para su cuenta.<br />
					<a onclick="$('#acordion1').accordion( 'option', 'active', 0 );">Volver al indice.</a>
				</div>
				
				<h3><a href="#">Salir del sistema</a></h3>
				<div>
					<a onclick="$('#acordion1').accordion( 'option', 'active', 0 );">Volver al indice.</a>
				</div>
			</div>	
			</td>
			<td>
			<div id="acordion2">
		
				<h3><a href="#">Eliminar mi cuenta</a></h3>
				<div>
					<a onclick="$('#acordion1').accordion( 'option', 'active', 0 );">Volver al indice.</a>
				</div>
				
				<h3><a href="#">Solicitar un turno</a></h3>
				<div>
					<a onclick="$('#acordion1').accordion( 'option', 'active', 0 );">Volver al indice.</a>
				</div>
				
				<h3><a href="#">Ver mis turnos reservados</a></h3>
				<div>
					<a onclick="$('#acordion1').accordion( 'option', 'active', 0 );">Volver al indice.</a>
				</div>
				
				<h3><a href="#">Cancelar un turno reservado</a></h3>
				<div>
					<a onclick="$('#acordion1').accordion( 'option', 'active', 0 );">Volver al indice.</a>
				</div>
				
				<h3><a href="#">¿Cuales son las notificaciones que voy a recibir?</a></h3>
				<div>
					<a onclick="$('#acordion1').accordion( 'option', 'active', 0 );">Volver al indice.</a>
				</div>
				
			</div>
			</td>
		</tr>
	</table>
	</div>
</div>
<!--<div class="actions">
	<h3>Acciones</h3>
	<ul>
		<li><?php echo $this->Html->link( 'Inicio', '/' ); ?></li>
		<li><?php echo $this->Html->link( 'Contacto', array( 'controller' => 'pages', 'contacto' ) ); ?></li>
		<li><?php echo $this->Html->link( 'Soporte', array( 'controller' => 'pages', 'soporte' ) ); ?></li>
		<li><?php echo $this->Html->link( 'Salir', array( 'controller' => 'usuarios', 'action' => 'salir' ) ); ?></li>
	</ul>
</div> -->