<?php
$this->set( 'title_for_layout', "Facebook" );
?>
<div class="row-fluid">
	
	<div class="span2" id="navegacion">
		<ul class="nav nav-list well affix span2">
			<li class="nav-header">Extras > Integración con facebook</li>
			<li><?php echo $this->Html->tag( 'a', '<i class="icon-chevron-right"></i>Ingreso sin registración', '#salir' ); ?></li>
			<li><?php echo $this->Html->tag( 'a', '<i class="icon-chevron-right"></i>Elementos disponibles', '#salir' ); ?></li>
		</ul>
	</div>
	
	<div class="span9 offset1">
		<h4>Integración con facebook</h4>
		<p>Este sistema le permite integrar la plataforma de turnos con el sistema de facebook.</p>
		
		<h5>Ingreso sin registración</h5>
		<p>Esta integración permite a los usuarios utilizar su cuenta de facebook para darse de alta al sistema y solicitar los turnos.<br />El sistema capturará los datos del usuario automaticamente y le permitirá realizar todas las mismas acciones tal cual si se hubiese dado de alta manualmente en el sitio.</p>
		<p>Agregar esta integración no elimina la posibilidad de seguir utilizando el sistema de usuarios normal de la aplicación.</p>
		
		<h5>Elementos disponibles para colocar</h5>
		<ul class="media-list">
			<li class="media">
				<div class="media-object pull-left thumbnail">
					<img src="https://fbcdn-dragon-a.akamaihd.net/cfs-ak-ash3/676570/74/425452970880849-/like.png" width="128" height="88">
				</div>
				<div class="media-body">
					<h6 class="media-heading">Botón Me Gusta</h6>
					<p>El botón me gusta le permite a los usuarios compartir paginas desde su sitio hacia su perfil de facebook con un solo click</p>
				</div>
			</li>
			<li class="media">
				<div class="media-object pull-left thumbnail">
					<img class="img" src="https://fbcdn-dragon-a.akamaihd.net/cfs-ak-prn1/676400/636/585310364815528-/send.png" width="128" height="88">
				</div>
				<div class="media-body">
					<h6 class="media-heading">Botón Enviar</h6>
					<p>El botón enviar le permite a los usuarios facilmente enviar contenido a sus amigos.</p>
				</div>
			</li>
			
			<li class="media">
				<div class="media-object pull-left thumbnail">
					<img class="img" src="https://fbcdn-dragon-a.akamaihd.net/cfs-ak-ash3/676528/839/343235882446936-/follow.png" width="128" height="88">
				</div>
				<div class="media-body">
					<h6 class="media-heading">Botón Seguir</h6>
					<p>El botón Segir permite a los usuario suscribirse a otras personas directamente desde tu sitio. ( También es llamado el boton de suscripción)</p>
				</div>
			</li>
			
			<li class="media">
				<div class="media-object pull-left thumbnail">
					<img class="img" src="https://fbcdn-dragon-a.akamaihd.net/cfs-ak-prn1/676551/223/161113474041532-/comments.png" width="128" height="88">
				</div>
				<div class="media-body">
					<h6 class="media-heading">Comentarios</h6>
					<p>El plugin de comentarios le permite a los usuarios dejar un comentario en cualquier lugar de tu sitio.</p>
				</div>
			</li>

 			<li class="media">
				<div class="media-object pull-left thumbnail">
					<img class="img" src="https://fbcdn-dragon-a.akamaihd.net/cfs-ak-ash3/676495/287/351053671676901-/activity.png" width="128" height="88">
				</div>
				<div class="media-body">
					<h6 class="media-heading">Actividad</h6>
					<p>El sistema de actividades le permite mostrar a los usuarios que están haciendo los amigos en el sitio a través del Me gusta y Comentarios.</p>
				</div>
			</li>
			
 			<li class="media">
				<div class="media-object pull-left thumbnail">
					<img class="img" src="https://fbcdn-dragon-a.akamaihd.net/cfs-ak-ash3/676670/313/570035976347835-/recommendations%20box.png" width="128" height="88">
				</div>
				<div class="media-body">
					<h6 class="media-heading">Caja de Recomendaciones</h6>
					<p>La caja de recomendaciónes le da la posibilidad a los usuarios de personalizar recomendaciones para páginas de tu sitio que le podrían llegar a interesar.</p>
				</div>
			</li>


 			<li class="media">
				<div class="media-object pull-left thumbnail">
					<img class="img" src="https://fbcdn-dragon-a.akamaihd.net/cfs-ak-prn1/676394/426/214524752024872-/recommendations%20bar.png" width="128" height="88">
				</div>
				<div class="media-body">
					<h6 class="media-heading">Barra de Recommendaciones</h6>
					<p>The Recommendations Bar allows users to like content, get recommendations, and share what they’re reading with their friends.</p>
				</div>
			</li>


 			<li class="media">
				<div class="media-object pull-left thumbnail">
					<img class="img" src="https://fbcdn-dragon-a.akamaihd.net/cfs-ak-prn1/676585/133/269615613171930-/like%20box.png" width="128" height="88">
				</div>
				<div class="media-body">
					<h6 class="media-heading">Caja de Like</h6>
					<p>The Like Box enables users to like your Facebook Page and view its stream directly from your website.</p>
				</div>
			</li>

 			<li class="media">
				<div class="media-object pull-left thumbnail">
					<img class="img" src="https://fbcdn-dragon-a.akamaihd.net/cfs-ak-ash3/676660/34/225190360939499-/facepile.png" width="128" height="88">
				</div>
				<div class="media-body">
					<h6 class="media-heading">Pila de Caras</h6>
					<p>The Facepile plugin displays the Facebook profile pictures of users who have liked your page or have signed up for your site.</p>
				</div>
			</li>
		</ul>
	</div>
</div>
