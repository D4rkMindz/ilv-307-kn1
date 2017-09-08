<?php $this->layout('view::Layout/layout.html.php') ?>
<div class="container">
	<h1>ERROR_<?= $this->v('code') ?></h1>
	<p ><?= $this->e(__('An error occured while browsing this Website. Please return to the previous Page.'))?></p>
</div>

