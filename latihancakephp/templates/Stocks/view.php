<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Stock $stock
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Stock'), ['action' => 'edit', $stock->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Stock'), ['action' => 'delete', $stock->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stock->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Stocks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Stock'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="stocks view content">
            <h3><?= h($stock->merk) ?></h3>
            <table>
                <tr>
                    <th><?= __('Merk') ?></th>
                    <td><?= h($stock->merk) ?></td>
                </tr>
                <tr>
                    <th><?= __('Model') ?></th>
                    <td><?= h($stock->model) ?></td>
                </tr>
                <tr>
                    <th><?= __('Engine Capacity') ?></th>
                    <td><?= h($stock->engine_capacity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Color') ?></th>
                    <td><?= h($stock->color) ?></td>
                </tr>
                <tr>
                    <th><?= __('Production Year') ?></th>
                    <td><?= h($stock->production_year) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($stock->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Price') ?></th>
                    <td><?= $this->Number->format($stock->price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($stock->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($stock->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($stock->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
