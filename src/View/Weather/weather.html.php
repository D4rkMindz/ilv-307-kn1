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
<h1>Feuchtigkeit</h1>
<div data-id="hu">
    <?php foreach ($this->v('humidity_images') as $key => $image): ?>
        <div data-id="hu<?= $key ?>" <?= $key > 0 ? 'class="hidden"' : 'class="shown"'; ?>>
            <img src="<?= $this->e($image); ?>" alt="" style="max-width: 100%;">
        </div>
    <?php endforeach; ?>
</div>
<div class="center">
    <div class="pagination">
        <a class="active" onclick="activateImage(0,'hu', this)">1</a>
        <a onclick="activateImage(1,'hu', this)">2</a>
        <a onclick="activateImage(2,'hu', this)">3</a>
        <a onclick="activateImage(3,'hu', this)">4</a>
        <a onclick="activateImage(4,'hu', this)">5</a>
        <a onclick="activateImage(5,'hu', this)">6</a>
        <a onclick="activateImage(6,'hu', this)">7</a>
    </div>
</div>
<h1>Temperatur</h1>
<div data-id="temp">
    <?php foreach ($this->v('temperature_images') as $key => $image): ?>
        <div data-id="temp<?= $key ?>" <?= $key > 0 ? 'class="hidden"' : 'class="shown"'; ?>>
            <img src="<?= $this->e($image); ?>" alt="" style="max-width: 100%;">
        </div>
    <?php endforeach; ?>
</div>
<div class="center">
    <div class="pagination">
        <a class="active" onclick="activateImage(0,'temp', this)">1</a>
        <a onclick="activateImage(1,'temp', this)">2</a>
        <a onclick="activateImage(2,'temp', this)">3</a>
        <a onclick="activateImage(3,'temp', this)">4</a>
        <a onclick="activateImage(4,'temp', this)">5</a>
        <a onclick="activateImage(5,'temp', this)">6</a>
        <a onclick="activateImage(6,'temp', this)">7</a>
    </div>
</div>
<h1>Wind</h1>
<div data-id="wind">
    <?php foreach ($this->v('wind_images') as $key => $image): ?>
        <div data-id="wind<?= $key ?>" <?= $key > 0 ? 'class="hidden"' : 'class="shown"'; ?>>
            <img src="<?= $this->e($image); ?>" alt="" style="max-width: 100%;">
        </div>
    <?php endforeach; ?>
</div>
<div class="center">
    <div class="pagination">
        <a class="active" onclick="activateImage(0,'wind', this)">1</a>
        <a onclick="activateImage(1,'wind', this)">2</a>
        <a onclick="activateImage(2,'wind', this)">3</a>
        <a onclick="activateImage(3,'wind', this)">4</a>
        <a onclick="activateImage(4,'wind', this)">5</a>
        <a onclick="activateImage(5,'wind', this)">6</a>
        <a onclick="activateImage(6,'wind', this)">7</a>
    </div>
</div>
