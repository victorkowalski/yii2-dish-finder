<?php if (!empty($dishes)): ?>
    <?php foreach ($dishes as $title => $ingredients): ?>
        <h3><?= $title?></h3>
        <p><?= $ingredients ?></p>
    <?php endforeach; ?>
<?php endif; ?>