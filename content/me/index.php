<?php
include "init.php";
$page->title = "About";
?>
<?php ob_start() ?>

<h1>Jordan Shurmer</h1>

<p>I am a Christian, a husband, and a dad. By trade, I am a software engineer.</p>

<p>This website is a place for me to try out new web technology, and a place to keep/organize some of my thoughts.</p>

<p>
    Twitter: <a target="_blank" href="https://twitter.com/jshurmer">@jshurmer</a>
    <br>
    Github:  <a target="_blank" href="https://github.com/JordanShurmer">JordanShurmer</a>
</p>
<?php $main = ob_get_clean() ?>

<?php include "layout.php" ?>

