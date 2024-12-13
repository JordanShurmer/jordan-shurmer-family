<?php
include "init.php";
$page->title = "Odin";
?>

<?php ob_start() ?>

<h1>Odin</h1>

<p>My exploration of the Odin language</p>

<p>
    I am not a game dev, but I'm learning how to write a game from (almost) scratch.
    My plan is to use <a target="_blank" href="https://odin-lang.org/">Odin</a> and
    <a target="_blank" href="https://www.raylib.com/">raylib</a>. I'll share useful
    things here
</p>


<ul>

    <li>
        <a href="/dev/odin/hot-reloading">Hot Reloading a Game</a>
    </li>


</ul>
<?php $main = ob_get_clean() ?>

<?php include "layout.php" ?>
