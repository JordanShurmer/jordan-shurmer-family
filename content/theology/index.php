<?php
include "data.php";
$page->title = "Theology";

ob_start();
?>


<h1>Theology Notes</h1>
<p>Some of my notes and musings on theological topics can be found here</p>

<ul>
    <li><a href="god/sovereignty.md">God's sovereignty</a></li>
    <li><a href="atonement.md">The Atonement</a></li>
    <li><a href="baptism.md">Baptism</a></li>
    <li><a href="regeneration.md">Regeneration</a></li>
    <li><a href="conversions-in-acts.md">Church Growth in Acts</a></li>
    <li><a href="god/gods-two-wills.md">God's two wills?</a></li>
</ul>

<?php $main = ob_get_clean(); ?>

<?php include "layout.php"; ?>
