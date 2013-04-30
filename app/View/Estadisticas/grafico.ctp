<!-- Genero el grafico correspondiente -->
<div id="<?php echo $nombre_div; ?>">Contenido del grafico aquí</div>
<?php echo $this->GoogleChart->createJsChart( $grafico, $nombre_div );?>