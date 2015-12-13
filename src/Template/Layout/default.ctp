<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->fetch('title') ?> : Sistema de turnos online</title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('bootstrap.min.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <header><?= $this->element('header'); ?></header>
    <div class="container" id="container">

        <div id="content">
            <?= $this->Flash->render() ?>
            <div class="row">
                <?= $this->fetch('content') ?>
            </div>
        </div>
        
    </div>
    <footer>
        <div style="float: left;"><?php echo $_SERVER['SERVER_NAME']; ?> &copy; 2012</div>
        <?php echo $this->Html->link(
                        $this->Html->image( 'tr.logo.png', array( 'alt' => "TR Sistemas Informaticos Integrados", 'border' => '0')),
                        'http://www.bscomputacion.org/',
                        array( 'target' => '_blank', 'escape' => false )
                );	
        ?>
    </footer>
</body>
</html>