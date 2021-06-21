import { basename } from "https://deno.land/std@0.99.0/path/mod.ts";
import postcss from "lume/plugins/postcss.js";
import lume from "lume/mod.js";

const site = lume();

// Ignore repo files that aren't part of the site
site.ignore("README.md")

// Copy the images and other static things
site.copy("static/favicon", "/")
site.copy("static")

// a TOC
// {{ content | toc | safe }}
// const toc = require('eleventy-plugin-nesting-toc');
// eleventyConfig.addPlugin(toc);

site.use(postcss({
    sourceMap: true
}));

site.data("slug", (path='unspecified') => {
    return basename(path) === "index" ? basename(path?.slice(0, -5)) : basename(path)
})

export default site;