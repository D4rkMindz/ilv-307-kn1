<?php $this->layout('view::Layout/layout.html.php'); ?>
<h1>Wetter</h1>
<div data-id="wi">
    <?php foreach ($this->v('weather_images') as $key => $image): ?>
        <div data-id="wi<?= $key ?>" <?= $key > 0 ? 'class="hidden"' : 'class="shown"'; ?>>
            <img src="<?= $this->e($image); ?>" alt="" style="max-width: 100%;">
        </div>
    <?php endforeach; ?>
</div>
<div class="center">
    <div class="pagination">
        <a class="active" onclick="activateImage(0,'wi', this)">1</a>
        <a onclick="activateImage(1,'wi', this)">2</a>
        <a onclick="activateImage(2,'wi', this)">3</a>
        <a onclick="activateImage(3,'wi', this)">4</a>
        <a onclick="activateImage(4,'wi', this)">5</a>
        <a onclick="activateImage(5,'wi', this)">6</a>
        <a onclick="activateImage(6,'wi', this)">7</a>
    </div>
</div>
