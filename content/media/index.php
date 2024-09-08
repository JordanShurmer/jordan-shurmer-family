<?php
include "init.php";
$page->title = "Media";
?>
<?php ob_start() ?>


<h1>Media</h1>
<p>My thoughts on various books I've read, music I listen too, etc..</p>


<ul>

    <li>
        <a href="/media/edwards-internet">Jonathan Edwards Predicts the Internet</a>
    </li>


    <li>
        <a href="/media/good-and-angry">Good and Angry</a>
    </li>


    <li>
        <a href="/media/hi-ren">Hi Ren</a>
    </li>


    <li>
        <a href="/media/liberal-arts-tradition">The Liberal Arts Tradition</a>
    </li>


    <li>
        <a href="/media/nf-hope">NF Hope</a>
    </li>


    <li>
        <a href="/media/ploductivity">Ploductivity</a>
    </li>


</ul>

<?php $main = ob_get_clean() ?>
<?php include "layout.php" ?>
