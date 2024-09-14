<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Purchase $purchase
 * @var \Cake\Collection\CollectionInterface|string[] $suppliers
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Purchases'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="purchases form content">
            <?= $this->Form->create($purchase) ?>
            <fieldset>
                <legend><?= __('Add Purchase') ?></legend>
                <?php
                    echo $this->Form->control('supplier_id', ['options' => $suppliers]);
                    echo $this->Form->control('merk');
                    echo $this->Form->control('model');
                    echo $this->Form->control('engine_capacity');
                    echo $this->Form->control('color');
                    echo $this->Form->control('production_year');
                    echo $this->Form->control('price');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
