<?php $this->layout('view::Layout/layout.html.php'); ?>
<?php
$conf = [
    [
        'name' => 'weather_images',
        'title' => 'Wetter',
        'prefix' => 'wi',
    ],
    [
        'name' => 'humidity_images',
        'title' => 'Feuchtigkeit',
        'prefix' => 'hu',
    ],
    [
        'name' => 'temperature_images',
        'title' => 'Temperatur',
        'prefix' => 'temp',
    ],
    [
        'name' => 'wind_images',
        'title' => 'Wind',
        'prefix' => 'wind',
    ],
];
foreach ($conf as $entry) :?>
    <h1><?= $this->e($entry['title']); ?></h1>
    <div data-id="<?= $this->e($entry['prefix']); ?>">
        <?php foreach ($this->v($entry['name']) as $key => $image): ?>
            <div data-id="<?= $this->e($entry['prefix']) . $key ?>" <?= $key > 0 ? 'class="hidden"' : 'class="shown"'; ?>>
                <img src="<?= $this->e($image); ?>" alt="" style="max-width: 100%;">
            </div>
        <?php endforeach; ?>
    </div>
    <div class="center">
        <div class="pagination">
            <a class="active" onclick="activateImage(0,'<?= $this->e($entry['prefix']); ?>', this)">1</a>
            <a onclick="activateImage(1,'<?= $this->e($entry['prefix']); ?>', this)">2</a>
            <a onclick="activateImage(2,'<?= $this->e($entry['prefix']); ?>', this)">3</a>
            <a onclick="activateImage(3,'<?= $this->e($entry['prefix']); ?>', this)">4</a>
            <a onclick="activateImage(4,'<?= $this->e($entry['prefix']); ?>', this)">5</a>
            <a onclick="activateImage(5,'<?= $this->e($entry['prefix']); ?>', this)">6</a>
            <a onclick="activateImage(6,'<?= $this->e($entry['prefix']); ?>', this)">7</a>
        </div>
    </div>
<?php endforeach; ?>
