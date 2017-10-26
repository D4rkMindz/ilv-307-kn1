<?php $this->layout('view::Layout/layout.html.php'); ?>
<?php
$category = $this->v('category');
foreach ($this->v('data') as $item):?>
    <div class="shopartikel">
        <img src="images/produkte/<?= $category; ?>/<?= $item['bildname']; ?>" class="shoppic" alt="Produktbild">
        <h2><?= $item['titel']; ?></h2>
        <p><?= $item['beschreibung']; ?></p>
        <p>CHF <?= $item['preis']?></p>
    </div>
<?php endforeach;?>
