<?php
include "init.php";
$page->title = "Ploductivity";
?>
<?php ob_start() ?>

<article itemscope itemtype="https://schema.org/Article">


    <h1 itemprop="headline name">Ploductivity</h1>

    <section itemprop="articleBody">

        <p>Really good &quot;productivity book&quot;. It's more of a Theology of Tools/Tech than it is a productivity book, but it is helpful in both those areas.</p>

    </section>

</article>

<?php $main = ob_get_clean() ?>

<?php include "layout.php" ?>
