<?php
include "init.php";
$page->title = "Theology";

ob_start();
?>


<h1>Theology Notes</h1>
<p>Some of my notes and musings on theological topics can be found here</p>

<ul>
    <li><a href="god/sovereignty">God's sovereignty</a></li>
    <li><a href="atonement">The Atonement</a></li>
    <li><a href="baptism">Baptism</a></li>
    <li><a href="regeneration">Regeneration</a></li>
    <li><a href="conversions-in-acts">Church Growth in Acts</a></li>
    <li><a href="god/gods-two-wills">God's two wills?</a></li>
</ul>

<?php $main = ob_get_clean(); ?>

<?php include "layout.php"; ?>
