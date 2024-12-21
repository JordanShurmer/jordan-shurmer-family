<?php
include "init.php";
$page->title = "Hot-Reloading in Odin";
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

<p>

There exists a
"<a href="https://github.com/karl-zylinski/odin-raylib-hot-reload-game-template">template</a>" that someone has created which will get you all of this,
    plus additional stuff. If you're looking for code that's where you will want to go.
    Thanks to Karl Zylinski for that.

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
    <pre><code>./build.sh -l</code></pre>

<p>

    The executable is built by compiling the main.odin file
    <pre><code>./build.sh -b</code></pre>

<p>


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

<p>

Define the game API. Set of functions that the game will export.
Run the game look, calling game.update() and game.draw() every frame.
Handle allocator setup/tracking.
Do the library linking.

<details>
    <summary>Full <code>main.odin</code> file</summary>
<pre><code>package main

import "core:dynlib"
import "core:fmt"
import "core:c/libc"
import "core:os"
import "core:log"
import "core:mem"

when ODIN_OS == .Windows {
    DLL_EXT :: ".dll"
} else {
    DLL_EXT :: ".lib" //yes, this does seem to work on mac and linux :/
}

// We copy the game code because using it directly would lock it,
// which would prevent the compiler from writing to it.
copy_game :: proc(to: string) -&gt; bool {
    if libc.system(fmt.ctprintf("cp game" + DLL_EXT + " {0}", to)) != 0 {
        fmt.printfln("Failed to copy game" + DLL_EXT + " to {0}", to)
        return false
    }
    return true
}

Game_API :: struct {
    create: proc(),
    init: proc(),
    update: proc() -&gt; bool,
    destroy: proc(keep_alive: bool),
    memory: proc() -&gt; rawptr,
    memory_size: proc() -&gt; int,
    hot_reload: proc(mem: rawptr),
    do_reset: proc() -&gt; bool,
    modification_time: os.File_Time,
    api_version: int,

    _game_handle: dynlib.Library,
}

// load and unload come from karl zylinski
// https://github.com/karl-zylinski/odin-raylib-hot-reload-game-template
load_game_api :: proc(api_version: int) -&gt; (api: Game_API, ok: bool) {
    mod_time, mod_time_error := os.last_write_time_by_name("game" + DLL_EXT)
    if mod_time_error != os.ERROR_NONE {
        fmt.printfln( "Failed getting last write time of game" + DLL_EXT + ", error code: {0}", mod_time_error)
        return
    }

    game_dll_name := fmt.tprintf("{0}game_{1}" + DLL_EXT, "./" when ODIN_OS != .Windows else "", api_version)
    copy_game(game_dll_name) or_return

    // passing in the return value &api
    _, ok = dynlib.initialize_symbols(&api, game_dll_name, "game_", "_game_handle")
    if !ok {
        fmt.printfln("Failed initializing symbols: {0}", dynlib.last_error())
        return;
    }

    api.api_version = api_version
    api.modification_time = mod_time
    ok = true

    return
}

unload_game_api :: proc(api: ^Game_API) {
    if api._game_handle != nil {
        if !dynlib.unload_library(api._game_handle) {
            fmt.printfln("Failed unloading _game_handle: {0}", dynlib.last_error())
        }
    }

    if os.remove(fmt.tprintf("game_{0}" + DLL_EXT, api.api_version)) != nil {
        fmt.printfln("Failed to remove game_{0}" + DLL_EXT + " copy", api.api_version)
    }
}

main :: proc() {
    context.logger = log.create_console_logger()
    log.info("starting...")

    // setup allocators, so we can warn about memory leaks
    default_allocator := context.allocator
    tracking_allocator: mem.Tracking_Allocator
    mem.tracking_allocator_init(&tracking_allocator, default_allocator)
    context.allocator = mem.tracking_allocator(&tracking_allocator)
    log.info("allocators ready")

    check_allocator :: proc(a: ^mem.Tracking_Allocator) -&gt; (err: bool) {
        for _, value in a.allocation_map {
            log.warn(value.size, "bytes leaked at", value.location)
            err = true
        }
        return
    }

    // INIT
    game_api, ok := load_game_api(0)
    defer unload_game_api(&game_api)
    log.info("game api:", ok)
    if !ok {
        log.error("Failed to load initial game api")
        return
    }

    game_api.create()
    defer game_api.destroy(false)


    rendition := 1
    still_running := true

    for still_running {
        still_running = game_api.update()

        file_time, _ := os.last_write_time_by_name("game" + DLL_EXT)


        // HARD reset when user asks us to
        if game_api.do_reset() {
            rendition += 1

            new_game_api, game_ok := load_game_api(rendition)
            if game_ok {

                game_api.destroy(true)
                //clean up the old game
                unload_game_api(&game_api)
                //init the new game
                game_api = new_game_api
                game_api.init()

            }
        }

        // HOT RELOAD when the file changes
        // reload the game with the new library, but exisitng memory
        if game_api.modification_time != file_time {
            rendition += 1

            new_game_api, game_ok := load_game_api(rendition)
            if game_ok {
                //HARD reset if actual memory struct change
                if size_of(game_api.memory()) != size_of(new_game_api.memory()) {

                    log.info("memory change. reseting")
                    game_api.destroy(true)
                    //clean up the old game
                    unload_game_api(&game_api)
                    //init the new game
                    game_api = new_game_api
                    game_api.init()

                } else {

                    //clean up the old game
                    preserved_memory := game_api.memory()
                    unload_game_api(&game_api)

                    //continue running on the new game
                    game_api = new_game_api
                    game_api.hot_reload(preserved_memory)

                }
            }
        }

        //clean up all our memory
        if len(tracking_allocator.bad_free_array) &gt; 0 {
            for b in tracking_allocator.bad_free_array {
                log.errorf("Bad free at: %v", b.location)
            }
            panic("Bad free detected")
        }

        free_all(context.temp_allocator)
    }

    free_all(context.temp_allocator)
    check_allocator(&tracking_allocator)
    mem.tracking_allocator_destroy(&tracking_allocator)
}

// some sort of GPU flags
@(export)
NvOptimusEnablement: u32 = 1
@(export)
AmdPowerXpressRequestHighPerformance: i32 = 1
</code></pre>
</details>

<p>

    First, we define an API that the dll will provide. The main executable will
    use these functions to run the game. This API is what gets swapped out during the
    <code>hot_reload</code> magic. A new implementation is loaded in and handed the memory
    from the already running game!

<pre><code>Game_API :: struct {
    create: proc(),
    update: proc() -&gt; bool,
    do_reset: proc() -&gt; bool,
    destroy: proc(keep_alive: bool),
    memory: proc() -&gt; rawptr,
    hot_reload: proc(mem: rawptr),
    _library: dynlib.Library,
    ///...
}


//in the main proc
for game_api.update() {
    //...
}
</code></pre>

<p>

    Then, in the game loop we check for the need to reload the game. We will reload in a
    couple different scenarios.

<ol>
    <li>if the game library is recompiled</li>
    <li>when you specifically request it in game</li>
</ol>

<pre><code>for game_api.update() {
    file_time, _ := os.last_write_time_by_name("game.lib")

    //explicitly asked for a hard reset (e.g. F6)
    if game_api.do_reset() {
        new_game := load_game_api()
        dynlib.unload_library(game_api._library)
        game_api = new_game_api
        game_api.init()
    }

    //HOT reload becase the game has been updated
    if game_api.modifiction_time != file_time {
        new_game := load_game_api()
        preserved_memory := game_api.memory()
        dynlib.unload_library(game_api._library)
        game_api = new_game_api

        //pass the existing memory in to the new impl
        game_api.hot_reload(preserved_memory)
    }
    
}
</code></pre>

<p>

    Note that this code has been simplified to communicate the intent more clearly. See the
    full file above, at the start of this section

<p>
    
    The <code>load_game_api()</code> reads the library from the new game.lib file, then
    uses dynlib to initialize it as a library.

This was taken from the immensely useful "<a href="https://github.com/karl-zylinski/odin-raylib-hot-reload-game-template">
template</a>" from <a href="https://github.com/karl-zylinski">Karl Zylinski</a>

<details>
    <summary><code>load_game_api()</code></summary>

<pre><code>load_game_api :: proc(api_version: int) -&gt; (api: Game_API, ok: bool) {
    mod_time, mod_time_error := os.last_write_time_by_name("game" + DLL_EXT)
    if mod_time_error != os.ERROR_NONE {
        fmt.printfln( "Failed getting last write time of game" + DLL_EXT + ", error code: {0}", mod_time_error)
        return
    }

    game_dll_name := fmt.tprintf("{0}game_{1}" + DLL_EXT, "./" when ODIN_OS != .Windows else "", api_version)
    copy_game(game_dll_name) or_return

    _, ok = dynlib.initialize_symbols(&amp;api, game_dll_name, "game_", "_library")
    if !ok {
        fmt.printfln("Failed initializing symbols: {0}", dynlib.last_error())
        return;
    }

    api.api_version = api_version
    api.modification_time = mod_time
    ok = true

    return
}
</code></pre>

</details>

<h5><code>game.odin</code></h5>

<p>

    Implement the game logic, in <code>update</code> and implement the game api functions.

<p>

    Note that these functions start with <code>game_</code> becuase the of dynlib call
    happening in main: <code>initialize_symbols(_, _, <strong>"game_"</strong>, _)</code>

<pre><code>struct GameMemory { ... }

update :: proc() {
    //implement your normal game logic here!
}

@(export)
game_update :: proc() -&gt; bool {
    update()
    return !rl.WindowShouldClose()
}

@(export)
game_init :: proc() {
    S = new(Game_Memory)
    S^ = Game_Memory { }
    game_hot_reload(S)
}

@(export)
game_destroy :: proc(keep_alive: bool) {
    free(S)
}

@(export)
game_memory :: proc() -&gt; rawptr {
    return S
}

@(export)
game_hot_reload :: proc(mem: rawptr) {
    S = (^Game_Memory)(mem)
}

//etc. implement game_api
</code></pre>

<p>

    There are a lot of details left out. See the full file above for a full example.

<hr>

<p>

    That's all there is to it! Use this and adapt it to your needs. It is a simple starting
    place for any game.

    <p>

    If you have questions or comments feel free to hit me up
    <a href="https://x.com/jshurmer">X</a>.



<!-- the ko-fi button -->
<div><a href='https://ko-fi.com/I2I217F38F' target='_blank'><img height='36' style='border:0px;height:36px;' src='https://storage.ko-fi.com/cdn/kofi1.png?v=6' border='0' alt='Buy Me a Coffee at ko-fi.com' /></a><div>

<?php $main = ob_get_clean() ?>

<?php include "layout.php" ?>
