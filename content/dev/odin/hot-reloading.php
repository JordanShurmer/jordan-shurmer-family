<?php
include "init.php";
$page->title = "Hot-Reloading in Odin";
$page->wip = true;
?>

<?php ob_start() ?>

<h1><?= $page->title ?></h1>

<p>
    Let's see how to hot-reload your game while you're developing it. 
</p>

<details>
    <summary>
        What Is Hot Reloading?
    </summary>


    What I'm talking about in this article is setting up your game such that you can
    change your game code, recompile the game, and see those changes immediately
    in an already running game window! You no longer have to re-open the game and move 
    your player back to the right location etc. Just change the code and see it live

    I come from the web dev world, and that type of functionality is typically called
    hot reloading. I assume there is a better word for it in the systems dev world. If
    so, let me know what it is.

</details>

<h2>How?</h2>

<p>
    We will accomplish this by writing the game code as a library, and then manually link
    that library from our <code>main</code> executable.
<p>
    When we recompile the library, the executable will detect the change and swap out
    the old library for the new one, but preserve the memory of the old. Then your newly
    compiled library will operate on the existing game state. Pretty cool.
</p>


<h3>The Code</h3>

<p>

    I will show how to accomplish this in 3 parts. The build, the executable, and the game
</p>

<h4>The Build</h4>

<p>
    It may be best to start with the compilation. This will show you the two main parts of
    your game in this paradigm
</p>

<style>
code, code > pre {
    overflow-x: scroll;
}
</style>

<code><pre>
    buildLib() {
        odin build game -build-mode:dll -out:/tmp/game.lib
        mv !$ game.lib
    }
    buildBin() {
        odin build main.odin -file
    }

    while getopts "bl" opt; do
        case $opt in
            b) buildBin ;;
            l) buildLib ;;
        esac
    done
</pre></code>



<?php $main = ob_get_clean() ?>

<?php include "layout.php" ?>
