<?php
include "init.php";
$page->title = "NF Hope";
$page->wip = true;
?>

<?php ob_start() ?>

<article itemscope itemtype="https://schema.org/Article">


    <h1 itemprop="headline name">NF Hope</h1>


    <section itemprop="articleBody">
        <p>Watch <a href="https://www.youtube.com/watch?v=tsmPCi7NKrg">the video</a></p>
        <p>This is a video, and a song, made for his fans.</p>
        <p>NF is declaring, visually and lyrically, that a new phase of NF music is coming.
            Fear is no longer in control, Hope is taking the reins.</p>
        <p>The NF dressed in white is <em>Hope</em>, the new NF. The NF dressed in black is <em>Fear</em>, the old NF.
            Watch <a href="https://www.youtube.com/watch?v=tsmPCi7NKrg">the video</a> again with this in mind. Hope is drifting in the ocean, but touches down as
            the song gets started. He immeditealy encounters Fear, who seems to be helping him find his way.
            However, Fear is just leading him in circles back to where he started, even pushing him back into
            his Mansion.</p>
        <p>Hope goes through some of the rooms that Fear has set up. Dealing with the same thoughts that Fear has already dealt with, but from
            a hopeful point of view.
            The burdens, mental breakdowns, and trauma are now a part of what made him who he is.</p>
        <p>Hope then details 31 ways that Fear has been leading his life in the wrong way. Fear tries to fight back, but Hope puts him in his place with the final two lines:</p>
        <blockquote>
            <p>Hope: I know I can change ....
                Fear: you don't have the guts
                Hope: you're the one afraid
                Fear: I'm the one in charge
                HOpe: I'm taking the reins</p>
        </blockquote>

    </section>
</article>


<?php $main = ob_get_clean() ?>

<?php include "layout.php" ?>
