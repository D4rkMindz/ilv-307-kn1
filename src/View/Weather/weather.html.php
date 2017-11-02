<?php $this->layout('view::Layout/layout.html.php');?>
<?php foreach ($this->v('weather_images') as $image):?>
    <img src="<?= $this->e($image);?>" alt="" style="max-width: 140%;">
<?php endforeach;?>