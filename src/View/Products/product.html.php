<?php $this->layout('view::Layout/layout.html.php'); ?>
<?php
$category = $this->v('category');
foreach ($this->v('data') as $item):?>
    <div class="shopartikel">
        <img src="images/produkte/<?= $category; ?>/<?= $item['bildname']; ?>" class="shoppic" alt="Produktbild">
        <h2><?= $item['titel']; ?></h2>
        <p><?= $item['beschreibung']; ?></p>
        <p>CHF <?= $item['preis']?></p>
        <div class="counter"><!-- <- For JS ^^ -->
            <input type="number" id="<?= $item['titel']; ?>" class="count" value="1">
            <button class="button" onclick="addToShoppingCart(this)">Zum Warenkorb hinzufügen</button>
        </div>
    </div>
<?php endforeach;?>
