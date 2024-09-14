<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Stock> $stocks
 */
?>
<div class="stocks index content">
    <?= $this->Html->link(__('New Stock'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Stocks') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('merk') ?></th>
                    <th><?= $this->Paginator->sort('model') ?></th>
                    <th><?= $this->Paginator->sort('engine_capacity') ?></th>
                    <th><?= $this->Paginator->sort('color') ?></th>
                    <th><?= $this->Paginator->sort('production_year') ?></th>
                    <th><?= $this->Paginator->sort('price') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stocks as $stock): ?>
                <tr>
                    <td><?= $this->Number->format($stock->id) ?></td>
                    <td><?= h($stock->merk) ?></td>
                    <td><?= h($stock->model) ?></td>
                    <td><?= h($stock->engine_capacity) ?></td>
                    <td><?= h($stock->color) ?></td>
                    <td><?= h($stock->production_year) ?></td>
                    <td><?= $this->Number->format($stock->price) ?></td>
                    <td><?= $this->Number->format($stock->quantity) ?></td>
                    <td><?= h($stock->created) ?></td>
                    <td><?= h($stock->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $stock->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $stock->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $stock->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stock->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
