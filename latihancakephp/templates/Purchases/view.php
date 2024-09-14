<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Purchase $purchase
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Purchase'), ['action' => 'edit', $purchase->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Purchase'), ['action' => 'delete', $purchase->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchase->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Purchases'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Purchase'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="purchases view content">
            <h3><?= h($purchase->merk) ?></h3>
            <table>
                <tr>
                    <th><?= __('Supplier') ?></th>
                    <td><?= $purchase->has('supplier') ? $this->Html->link($purchase->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $purchase->supplier->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Merk') ?></th>
                    <td><?= h($purchase->merk) ?></td>
                </tr>
                <tr>
                    <th><?= __('Model') ?></th>
                    <td><?= h($purchase->model) ?></td>
                </tr>
                <tr>
                    <th><?= __('Engine Capacity') ?></th>
                    <td><?= h($purchase->engine_capacity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Color') ?></th>
                    <td><?= h($purchase->color) ?></td>
                </tr>
                <tr>
                    <th><?= __('Production Year') ?></th>
                    <td><?= h($purchase->production_year) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($purchase->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Price') ?></th>
                    <td><?= $this->Number->format($purchase->price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($purchase->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($purchase->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
