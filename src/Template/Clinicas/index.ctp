<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Clinica'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Consultorios'), ['controller' => 'Consultorios', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Consultorio'), ['controller' => 'Consultorios', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Medicos'), ['controller' => 'Medicos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Medico'), ['controller' => 'Medicos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Secretarias'), ['controller' => 'Secretarias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Secretaria'), ['controller' => 'Secretarias', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="clinicas index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id_clinica') ?></th>
            <th><?= $this->Paginator->sort('telefono') ?></th>
            <th><?= $this->Paginator->sort('email') ?></th>
            <th><?= $this->Paginator->sort('logo') ?></th>
            <th><?= $this->Paginator->sort('lat') ?></th>
            <th><?= $this->Paginator->sort('lng') ?></th>
            <th><?= $this->Paginator->sort('zoom') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($clinicas as $clinica): ?>
        <tr>
            <td><?= $this->Number->format($clinica->id_clinica) ?></td>
            <td><?= $this->Number->format($clinica->telefono) ?></td>
            <td><?= h($clinica->email) ?></td>
            <td><?= h($clinica->logo) ?></td>
            <td><?= h($clinica->lat) ?></td>
            <td><?= h($clinica->lng) ?></td>
            <td><?= h($clinica->zoom) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $clinica->id_clinica]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clinica->id_clinica]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $clinica->id_clinica], ['confirm' => __('Are you sure you want to delete # {0}?', $clinica->id_clinica)]) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
