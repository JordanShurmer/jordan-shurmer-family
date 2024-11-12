<?php
include "init.php";
$page->title = "Nov 11 2024";
?>

<?php ob_start() ?>

<h1>Nov 11 2024</h1>

<p>I need to actually ship!</p>


<?php $main = ob_get_clean() ?>

<?php include "layout.php" ?>
