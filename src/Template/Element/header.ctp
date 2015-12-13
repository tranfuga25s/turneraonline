<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
        <span class="sr-only"><?= __("Toggle navigation"); ?></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        <a class="navbar-brand" href="#">
            <?= $this->Html->image('cabecera.png', array('class' => 'img-responsive', 'border' => 0)); ?>
        </a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#"><?= __("Inicio"); ?></a></li>
        <li><a href="#">Contacto</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Servicios <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <!-- <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li class="divider"></li>
            <li><a href="#">One more separated link</a></li> -->
          </ul>
        </li>
      </ul>
        <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="#"><?= $this->Html->image('ayuda.png'); ?></a>
        </li>
      </ul>
      <form class="navbar-form navbar-right" role="search">
        <div class="form-group">
          <input class="form-control" placeholder="<?= __("Buscar"); ?>" type="text">
        </div>
        <button type="submit" class="btn btn-default"><?= __("Buscar"); ?></button>
      </form>
      
    </div>
  </div>
</nav>