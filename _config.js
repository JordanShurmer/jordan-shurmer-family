import { basename } from "https://deno.land/std@0.180.0/path/mod.ts";
import lume from "https://deno.land/x/lume@v1.15.3/mod.ts";
import postcss from "https://deno.land/x/lume@v1.15.3/plugins/postcss.ts";

const site = lume();

// Ignore repo files that aren't part of the site
site.ignore("README.md")

// Copy the images and other static things
site.copy("static/favicon", "/")
site.copy("static")

site.use(postcss({
    sourceMap: true
}));


site.data("slug", (path='unspecified') => {
    return basename(path) === "index" ? basename(path?.slice(0, -5)) : basename(path)
})

export default site;
