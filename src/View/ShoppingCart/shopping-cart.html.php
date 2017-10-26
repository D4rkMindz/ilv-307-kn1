<?php $this->layout('view::Layout/layout.html.php'); ?>
<?php foreach ($this->v('data') as $name =>$count):?>
    <div class="cart-item">
        <button class="button inline">Bearbeiten</button>
        <button class="button inline" style="background-color: red; border: 1px solid darkred">Löschen</button>
        <h3 class="inline title"><?= $this->e($name)?> (<?= $this->e($count)?>)</h3>
    </div>
<?php endforeach;?>
