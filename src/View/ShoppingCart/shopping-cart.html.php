<?php $this->layout('view::Layout/layout.html.php'); ?>
<?php foreach ($this->v('data') as $name =>$count):?>
    <div class="cart-item">
        <h3><?= $this->e($name)?> (<?= $this->e($count)?>)</h3>
    </div>
<?php endforeach;?>
