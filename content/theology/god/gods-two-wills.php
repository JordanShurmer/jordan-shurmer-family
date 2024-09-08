<?php
include "init.php";
$page->title = "God's Two Wills";
$page->wip = true;
?>

<?php ob_start() ?>

<article itemscope itemtype="https://schema.org/Article">

    <h1 itemprop="headline name">God&#39;s Two Wills</h1>

    <p itemprop="description">
        A look into my view of the so-called &quot;two wills&quot; of God
    </p>

    <section itemprop="articleBody">
        <section>
            <h2>Introduction</h2>
            <p>
                <scripture-list
                    api="crosswayApi"
                    reference-list='["Lamentations 3:43-33"]'
                </scripture-list>
        </section>

        <section>

            <h2>Peter's two uses</h2>
            <p>
                <scripture-list
                    api="crosswayApi"
                    reference-list='[
                    "1 Peter 2:15, 4:2",
                    "1 Peter 3:17, 4:19"
                    ]'>
                </scripture-list>
        </section>

        <section>
            <h2>Examples</h2>
            <ul>
                <li>Abraham sacrificing Isaac</li>
                <li>Hardening Pharaoh's heart</li>
                <li>Egyptians hating the Jews (Psalm 105:25)</li>
                <li>Evil against David (2 Samuel 12:11)</li>
                <li>The death of Christ</li>
                <li>The war against the lamb (Revelation 17:16-17)</li>
            </ul>

            <p>
                <scripture-list
                    api="crosswayApi"
                    reference-list='[
                    "Exodus 4:21",
                    "Deuteronomy 2:30",
                    "Deuteronomy 28:63",
                    "Joshua 11:19-20",
                    "1 Samuel 2:25",
                    "2 Samuel 12:11",
                    "Psalm 105:25",
                    "Amos 3:6",
                    "Romans 11:7-9, 25-26",
                    "Revelation 17:16-17"
                    ]'>
                </scripture-list>
        </section>

        <section>
            <h2>Resources</h2>

            <p>
                John Piper: <a target="_blank" href="https://www.desiringgod.org/articles/are-there-two-wills-in-god">Are there two wills in God</a>
            </p>

        </section>

</article>

<?php $main = ob_get_clean() ?>

<?php include "layout.php" ?>
