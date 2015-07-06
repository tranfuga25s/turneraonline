<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $clinica->id_clinica],
                ['confirm' => __('Are you sure you want to delete # {0}?', $clinica->id_clinica)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Clinicas'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Consultorios'), ['controller' => 'Consultorios', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Consultorio'), ['controller' => 'Consultorios', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Medicos'), ['controller' => 'Medicos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Medico'), ['controller' => 'Medicos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Secretarias'), ['controller' => 'Secretarias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Secretaria'), ['controller' => 'Secretarias', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="clinicas form large-10 medium-9 columns">
    <?= $this->Form->create($clinica) ?>
    <fieldset>
        <legend><?= __('Edit Clinica') ?></legend>
        <?php
            echo $this->Form->input('nombre');
            echo $this->Form->input('direccion');
            echo $this->Form->input('telefono');
            echo $this->Form->input('email');
            echo $this->Form->input('logo');
            echo $this->Form->input('lat');
            echo $this->Form->input('lng');
            echo $this->Form->input('zoom');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
