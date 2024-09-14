<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee $employee
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Employees'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="employees form content">
            <?= $this->Form->create($employee) ?>
            <fieldset>
                <legend><?= __('Add Employee') ?></legend>
                <?php
                    echo $this->Form->control('username');
                    echo $this->Form->control('fullname');
                    echo $this->Form->control('role', ['options' => ['Manager' => 'Manager', 'Supervisor' => 'Supervisor', 'Web Developer' => 'Web Developer', 'Sales' => 'Sales']]);
                    echo $this->Form->control('phone');
                    echo $this->Form->control('email');
                    echo $this->Form->control('address');
                    echo $this->Form->control('password');
                    echo $this->Form->control('last_login');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
