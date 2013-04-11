<div class="row-fluid">
	
	<div class="span2" id="navegacion">
		<ul class="nav nav-list well affix span2">
			<li class="nav-header"><?php echo $this->Html->tag( 'a', 'Indice', '#top' ); ?></li>
			<li><?php echo $this->Html->tag( 'a', '<i class="icon-chevron-right"></i>P&aacute;gina de inicio', '#inicio' ); ?></li>
			<li><?php echo $this->Html->tag( 'a', '<i class="icon-chevron-right"></i>Registrarse', '#registrarse' ); ?></li>
			<li><?php echo $this->Html->tag( 'a', '<i class="icon-chevron-right"></i>Olvid&eacute; mi contrase&ntilde;a', '#recuperar' ); ?></li>
			<li><?php echo $this->Html->tag( 'a', '<i class="icon-chevron-right"></i>Salir del sistema', '#salir' ); ?></li>
			<li><?php echo $this->Html->tag( 'a', '<i class="icon-chevron-right"></i>Eliminar mi cuenta', '#eliminar' ); ?></li>
			<li class="divider"></li>
			<li class="nav-header">Turnos</li>
			<li><?php echo $this->Html->tag( 'a', '<i class="icon-chevron-right"></i>Solicitar un turno', '#' ); ?></li>
			<li><?php echo $this->Html->tag( 'a', '<i class="icon-chevron-right"></i>Ver mis turnos reservados', '#' ); ?></li>
			<li><?php echo $this->Html->tag( 'a', '<i class="icon-chevron-right"></i>Cancelar un turno reservado', '#' ); ?></li>
			<li class="divider"></li>
			<li class="nav-header">Notificaciones</li>
			<li><?php echo $this->Html->tag( 'a', '<i class="icon-chevron-right"></i>¿Cuales son las notificaciones que voy a recibir?', '#salir' ); ?></li>
		</ul>
	</div>
	
	<div class="span10 well" id="contenido">
		<h3>Ayuda para el sistema</h3>
		<p><b>Bienvenido a la ayuda!</b></p>
		<p>Aqu&iacute; encontrar&aacute; los consejos necesarios para utilizar el sistema.</p>
		
		<section>
			<h4><a id="inicio">Pagina de inicio</a></h4>
			La página de inicio del sistema le mostrará las acciónes disponibles para realizar dentro del sistema.<br />
			Las acciónes que podrá realizar son:
			<ul>
				<li><a href="#solicitar">Solicitar un turno</a></li>
				<li><a href="#ver">Ver sus turnos</a></li>
				<li><a href="#salir">Salir del sistema</a></li>
			</ul>
		</section>
		
		<section id="registrarse">
			<h4><a href="#">Registrarse</a></h4>
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
			Todos los datos serán utilizados solamente por personal de la clinica y no se compartirán con ningún externo.
		</section>
		
		<section id="recuperar">
			<h4><a href="#">Olvide mi contraseña</a></h4>
			Para recuperar su contraseña deberá utilizar la opción <b>Olvidé mi contraseña</b> en la pantalla de inicio.<br />
			Al ingresar en esa opción se le solicitará la cuenta de correo con la que se dió de alta en el sistema.<br />
			<br />
			El sistema verificará que la dirección de correo electrónico se encuentre en nuestra base de datos y de encontrarse registrado mediante esa dirección el sistema enviará un email que contiene los datos de su ususario y una nueva contraseña generada automaticamente.<br />
			Para ingresar con su nueva contraseña copie desde el email la contraseña y pegelá en el formulario de la página inicial.<br />
			Para cambiar su contraseña, una vez que haya ingresado al sistema, ingrese a la opción "Mis datos".<br />
			Allí encontrará la opción "cambiar mi contraseña" donde podrá colocar una nueva contraseña para su cuenta.<br />
		</section>
		
		<section id="salir">
			<h4><a href="#">Salir del sistema</a></h4>
		</section>
		<section id="eliminar">
			<h4><a href="#">Eliminar mi cuenta</a></h4>
		</section>				
		<section id="solicitar">
			<h4><a href="#">Solicitar un turno</a></h4>
		</section>
		<section id="turnos">
			<h4><a href="#">Ver mis turnos reservados</a></h4>
		</section>
		<section id="cancelar">
			<h4><a href="#">Cancelar un turno reservado</a></h4>
		</section>
		<section id="notificaciones">
			<h4><a href="#">¿Cuales son las notificaciones que voy a recibir?</a></h4>
		</section>			
	</div>
	
</div>