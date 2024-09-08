<?php
include "Parsedown.php";
$Parsedown = new Parsedown();

class Page {
    public string $hero_image = "";
    public string $title = "";
    public bool $wip = false;
}
$page = new Page();

?>
