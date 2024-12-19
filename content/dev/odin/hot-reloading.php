<?php
include "init.php";
$page->title = "Hot-Reloading in Odin";
$page->wip = true;
?>

<?php ob_start() ?>
<?php $left = ob_get_clean() ?>

<?php ob_start() ?>

<h1><?= $page->title ?></h1>

<p>
    Let's see how to hot-reload your game while you're developing it. 

<p>
    This will get you a minimal starting point to get a hot reloading game. Start here
    and adapt to your particular projects
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
pre {
    overflow-x: auto;
}
pre > code {
    overflow-x: auto;
    display: block;
    border: 2px solid var(--color);
    padding: 1ch;
}
</style>

<pre class=code-block><code>buildLib() {
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
</code></pre>

<p>
    The game logic itself is built as a library using <code>-build-mode:dll</code> (dll stands for
    dynamically linked library. You can use several similar words instead. See `odin help build`)

<p>
    The executable is built by compiling the main.odin file

<p>
    <em>note:</em> if you are using one of the odin 'vendor' libraries like raylib or sdl2
    you will need to manually link those in during the build step. Expand the following details
    for an example using raylib.
</p>

<details>
    <summary>full build.sh with raylib</summary>

<pre class=code-block><code>buildLib() {

    odin build game \
    -build-mode:dll \
    -out:/tmp/game.lib \
    -define:RAYLIB_SHARED=true \
    -extra-linker-flags:"-Wl,-rpath $(odin root)vendor/raylib/linux"

    # NOTE:
    # -define:RAYLIB_SHARE=true is how the reylib library itself knows it's being loaded in as a shared library
    # -extra-linker-flags:"..." is us manually linking teh raylib vendor library

    # create a temp file and then move it, because the odin build clears the
    # existing file at the start, thereby triggering our hot reload when it should not
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
done</code></pre>
</details>

<h4>The Odin Code</h4>

The odin code has been split into two files. <code>main</code> contains the executable and
the manually linking stuff (as well as the game loop). <code>game</code> contains the game
logic in an <code>update</code> method that gets called every game loop, as well as other game api things.

<h5><code>main.odin</code></h5>

Define the game API. Set of functions that the game will export.
Run the game look, calling game.update() and game.draw() every frame.
Handle allocator setup/tracking.
Do the library linking.

<pre><code>#TODO: fill this in
</code></pre>

<h5><code>game.odin</code></h5>

Implement the game logic, in <code>update</code> and implement the game api functions.

<pre><code>#TODO: fill this in
</code></pre>

<!-- the ko-fi button -->
<a href='https://ko-fi.com/I2I217F38F' target='_blank'><img height='36' style='border:0px;height:36px;' src='https://storage.ko-fi.com/cdn/kofi1.png?v=6' border='0' alt='Buy Me a Coffee at ko-fi.com' /></a>

<?php $main = ob_get_clean() ?>

<?php include "layout.php" ?>
