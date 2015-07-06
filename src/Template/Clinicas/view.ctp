<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Clinica'), ['action' => 'edit', $clinica->id_clinica]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Clinica'), ['action' => 'delete', $clinica->id_clinica], ['confirm' => __('Are you sure you want to delete # {0}?', $clinica->id_clinica)]) ?> </li>
        <li><?= $this->Html->link(__('List Clinicas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Clinica'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Consultorios'), ['controller' => 'Consultorios', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Consultorio'), ['controller' => 'Consultorios', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Medicos'), ['controller' => 'Medicos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Medico'), ['controller' => 'Medicos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Secretarias'), ['controller' => 'Secretarias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Secretaria'), ['controller' => 'Secretarias', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="clinicas view large-10 medium-9 columns">
    <h2><?= h($clinica->id_clinica) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Email') ?></h6>
            <p><?= h($clinica->email) ?></p>
            <h6 class="subheader"><?= __('Logo') ?></h6>
            <p><?= h($clinica->logo) ?></p>
            <h6 class="subheader"><?= __('Lat') ?></h6>
            <p><?= h($clinica->lat) ?></p>
            <h6 class="subheader"><?= __('Lng') ?></h6>
            <p><?= h($clinica->lng) ?></p>
            <h6 class="subheader"><?= __('Zoom') ?></h6>
            <p><?= h($clinica->zoom) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id Clinica') ?></h6>
            <p><?= $this->Number->format($clinica->id_clinica) ?></p>
            <h6 class="subheader"><?= __('Telefono') ?></h6>
            <p><?= $this->Number->format($clinica->telefono) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <?= $this->Text->autoParagraph(h($clinica->nombre)) ?>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Direccion') ?></h6>
            <?= $this->Text->autoParagraph(h($clinica->direccion)) ?>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Consultorios') ?></h4>
    <?php if (!empty($clinica->consultorios)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id Consultorio') ?></th>
            <th><?= __('Clinica Id') ?></th>
            <th><?= __('Nombre') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($clinica->consultorios as $consultorios): ?>
        <tr>
            <td><?= h($consultorios->id_consultorio) ?></td>
            <td><?= h($consultorios->clinica_id) ?></td>
            <td><?= h($consultorios->nombre) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Consultorios', 'action' => 'view', $consultorios->id_consultorio]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Consultorios', 'action' => 'edit', $consultorios->id_consultorio]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Consultorios', 'action' => 'delete', $consultorios->id_consultorio], ['confirm' => __('Are you sure you want to delete # {0}?', $consultorios->id_consultorio)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Medicos') ?></h4>
    <?php if (!empty($clinica->medicos)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id Medico') ?></th>
            <th><?= __('Usuario Id') ?></th>
            <th><?= __('Especialidad Id') ?></th>
            <th><?= __('Clinica Id') ?></th>
            <th><?= __('Visible') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($clinica->medicos as $medicos): ?>
        <tr>
            <td><?= h($medicos->id_medico) ?></td>
            <td><?= h($medicos->usuario_id) ?></td>
            <td><?= h($medicos->especialidad_id) ?></td>
            <td><?= h($medicos->clinica_id) ?></td>
            <td><?= h($medicos->visible) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Medicos', 'action' => 'view', $medicos->id_medico]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Medicos', 'action' => 'edit', $medicos->id_medico]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Medicos', 'action' => 'delete', $medicos->id_medico], ['confirm' => __('Are you sure you want to delete # {0}?', $medicos->id_medico)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Secretarias') ?></h4>
    <?php if (!empty($clinica->secretarias)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id Secretaria') ?></th>
            <th><?= __('Usuario Id') ?></th>
            <th><?= __('Clinica Id') ?></th>
            <th><?= __('Resumen') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($clinica->secretarias as $secretarias): ?>
        <tr>
            <td><?= h($secretarias->id_secretaria) ?></td>
            <td><?= h($secretarias->usuario_id) ?></td>
            <td><?= h($secretarias->clinica_id) ?></td>
            <td><?= h($secretarias->resumen) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Secretarias', 'action' => 'view', $secretarias->id_secretaria]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Secretarias', 'action' => 'edit', $secretarias->id_secretaria]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Secretarias', 'action' => 'delete', $secretarias->id_secretaria], ['confirm' => __('Are you sure you want to delete # {0}?', $secretarias->id_secretaria)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
