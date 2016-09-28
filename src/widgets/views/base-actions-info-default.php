<?php

/**
 * @var array $attributes
 * @var \yii\web\View $this
 */

?>
<?php foreach ($attributes as $attribute) : ?>
    <div>
        <label><?= $attribute['label'] ?></label>
        <div class="form-control"><?= $attribute['value'] ?></div>
        <div class="help-block"></div>
    </div>
<?php endforeach; ?>
