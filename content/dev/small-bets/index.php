<?php
include "init.php";
$page->title = "Small Bets";
?>

<?php ob_start() ?>

<h1>Small Bets</h1>
<p>Some ideas, and notes about ideas for software projects</p>


<ul>
    <?php foreach (scandir('.') as $file): ?>
    <?php if (is_file($file) && preg_match('/^\d/', $file)): ?>
    <li>
        <a href="<?= htmlspecialchars($file) ?>"><?= htmlspecialchars(rtrim($file, '.php')) ?></a>
    </li>
    <?php endif; ?>
    <?php endforeach; ?>
</ul>


<?php $main = ob_get_clean() ?>

<?php include "layout.php" ?>
