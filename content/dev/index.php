<?php
include "init.php";
$page->title = "Development";
?>

<?php ob_start() ?>

<h1>Dev Notes</h1>
<p>Some of my notes, thoughts, and experiments in the world of software engineering.</p>


<ul>


    <li>
        <a href="/dev/scripture-web-components">Web Components: Scripture</a>
    </li>



</ul>
<?php $main = ob_get_clean() ?>

<?php include "layout.php" ?>
