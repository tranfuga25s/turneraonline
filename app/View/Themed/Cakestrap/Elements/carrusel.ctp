<style>
.texto-carrusel {
	text-align: center;
	font-size: 27px;
	text-transform: uppercase;
	font-weight: bold;
	background: lightblue;
	padding: 20px;
	color: white;
	border-radius: 0 0 9px 9px;
}

.texto-carrusel:hover {
	text-decoration: none;
}

.carousel-inner>.item>img, .carousel-inner>.item>a>img {
	border-radius: 9px 9px 0 0;
}
</style>

<h3>¿Para qui&eacute;nes es &uacute;til?</h3>
<div id="myCarousel" class="carousel slide">
	<ol class="carousel-indicators">
		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		<li data-target="#myCarousel" data-slide-to="1"></li>
		<li data-target="#myCarousel" data-slide-to="2"></li>
		<li data-target="#myCarousel" data-slide-to="3"></li>
		<li data-target="#myCarousel" data-slide-to="4"></li>
		<li data-target="#myCarousel" data-slide-to="5"></li>
		<!-- <li data-target="#myCarousel" data-slide-to="6"></li> -->
	</ol>
	<!-- Carousel items -->
	<div class="carousel-inner">
	    <div class="active item">
	    	<?php echo $this->Html->link( 
	    		$this->Html->image( 'slide-medico.png' ).
	    		$this->Html->tag('div', 'M&eacute;dicos', array( 'class' => 'texto-carrusel' ) ),
	    	 array( 'controller' => 'pages/clientes/medicos' ),
	    	 array( 'escape' => false ) ); ?>
	   	</div>
	    <div class="item">
	    	<?php echo $this->Html->link( 
	    		$this->Html->image( 'slide-consultorio.png'   ).
	    		$this->Html->tag('div', 'Consultorios', array( 'class' => 'texto-carrusel' ) ),
	    	array( 'controller' => 'pages/clientes/consultorios' ),
	    	array( 'escape' => false ) ); ?>
	    </div>
	    <div class="item">
	    	<?php echo $this->Html->link( 
	    			$this->Html->image( 'slide-hospital.png'      ).
	    			$this->Html->tag('div', 'Sanatorios y/o Hospitales', array( 'class' => 'texto-carrusel' ) ),
	    		 array( 'controller' => 'pages/clientes/hospital'     ),
	    		 array( 'escape' => false ) ); ?>
	    </div>
	    <div class="item">
	    	<?php echo $this->Html->link( 
	    			$this->Html->image( 'slide-dentista.png'      ).
	    			$this->Html->tag('div', 'Dentistas', array( 'class' => 'texto-carrusel' ) ),
	    		 array( 'controller' => 'pages/clientes/dentista'     ),
	    		 array( 'escape' => false ) ); ?>
	    </div>
	    <div class="item">
	    	<?php echo $this->Html->link( 
	    					$this->Html->image( 'slide-belleza.png' ).
	    					$this->Html->tag('div', 'Salones de Belleza', array( 'class' => 'texto-carrusel' ) ),
	    			   array( 'controller' => 'pages/clientes/belleza'      ),
	    			   array( 'escape' => false ) ); ?>
	    </div>
	    <!-- <div class="item">
	    	<?php echo $this->Html->link( 
	    					$this->Html->image( 'slide-futbol.png' ).
	    					$this->Html->tag( 'div', 'Canchas de F&uacute;tbol', array( 'class' => 'texto-carrusel' ) ),
	    			   array( 'controller' => 'pages/clientes/futbol'       ),
	    			   array( 'escape' => false ) ); ?>
	    </div>
	    <div class="item">
	    	<?php echo $this->Html->link( 
	    					$this->Html->image( 'slide-tenis.png'         ).
	    					$this->Html->tag('div', 'Canchas de Tenis', array( 'class' => 'texto-carrusel' ) ),
	    				array( 'controller' => 'pages/clientes/tenis'        ),
	    				array( 'escape' => false ) ); ?>
	    </div> -->
    </div>
	<!-- Carousel nav -->
	<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
	<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
</div>