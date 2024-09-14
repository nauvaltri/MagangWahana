<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PurchaseTransaction $purchaseTransaction
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Purchase Transaction'), ['action' => 'edit', $purchaseTransaction->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Purchase Transaction'), ['action' => 'delete', $purchaseTransaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseTransaction->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Purchase Transactions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Purchase Transaction'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="purchaseTransactions view content">
            <h3><?= h($purchaseTransaction->code) ?></h3>
            <table>
                <tr>
                    <th><?= __('Employee') ?></th>
                    <td><?= $purchaseTransaction->has('employee') ? $this->Html->link($purchaseTransaction->employee->username, ['controller' => 'Employees', 'action' => 'view', $purchaseTransaction->employee->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Purchase') ?></th>
                    <td><?= $purchaseTransaction->has('purchase') ? $this->Html->link($purchaseTransaction->purchase->merk, ['controller' => 'Purchases', 'action' => 'view', $purchaseTransaction->purchase->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($purchaseTransaction->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($purchaseTransaction->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Price') ?></th>
                    <td><?= $this->Number->format($purchaseTransaction->price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($purchaseTransaction->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Price') ?></th>
                    <td><?= $this->Number->format($purchaseTransaction->total_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Transaction Date') ?></th>
                    <td><?= h($purchaseTransaction->transaction_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($purchaseTransaction->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($purchaseTransaction->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Purchase Payments') ?></h4>
                <?php if (!empty($purchaseTransaction->purchase_payments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Purchase Transaction Id') ?></th>
                            <th><?= __('Nominal') ?></th>
                            <th><?= __('Payment Method') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Payment Date') ?></th>
                            <th><?= __('Proof') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($purchaseTransaction->purchase_payments as $purchasePayments) : ?>
                        <tr>
                            <td><?= h($purchasePayments->id) ?></td>
                            <td><?= h($purchasePayments->purchase_transaction_id) ?></td>
                            <td><?= h($purchasePayments->nominal) ?></td>
                            <td><?= h($purchasePayments->payment_method) ?></td>
                            <td><?= h($purchasePayments->status) ?></td>
                            <td><?= h($purchasePayments->payment_date) ?></td>
                            <td><?= h($purchasePayments->proof) ?></td>
                            <td><?= h($purchasePayments->created) ?></td>
                            <td><?= h($purchasePayments->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PurchasePayments', 'action' => 'view', $purchasePayments->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PurchasePayments', 'action' => 'edit', $purchasePayments->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PurchasePayments', 'action' => 'delete', $purchasePayments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchasePayments->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
