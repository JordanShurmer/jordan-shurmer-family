import postcss from "https://deno.land/x/lume@v0.14.0/plugins/postcss.js";
import lume from "https://raw.githubusercontent.com/JordanShurmer/lume/8880f6332a317814c1b3a3ea4906d58087672eee/mod.js";

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

export default site;