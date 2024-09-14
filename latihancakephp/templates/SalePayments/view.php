<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SalePayment $salePayment
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Sale Payment'), ['action' => 'edit', $salePayment->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Sale Payment'), ['action' => 'delete', $salePayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salePayment->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Sale Payments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Sale Payment'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="salePayments view content">
            <h3><?= h($salePayment->payment_method) ?></h3>
            <table>
                <tr>
                    <th><?= __('Sale Transaction') ?></th>
                    <td><?= $salePayment->has('sale_transaction') ? $this->Html->link($salePayment->sale_transaction->id, ['controller' => 'SaleTransactions', 'action' => 'view', $salePayment->sale_transaction->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment Method') ?></th>
                    <td><?= h($salePayment->payment_method) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($salePayment->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Proof') ?></th>
                    <td><?= h($salePayment->proof) ?></td>
                </tr>
                
                <tr>
                    <th><?= __('Voucher') ?></th>
                    <td><?= h($salePayment->voucher) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($salePayment->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nominal') ?></th>
                    <td><?= $this->Number->format($salePayment->nominal) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment Date') ?></th>
                    <td><?= h($salePayment->payment_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($salePayment->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($salePayment->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
