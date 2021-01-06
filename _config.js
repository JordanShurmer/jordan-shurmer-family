import css from "https://deno.land/x/lume/plugins/css.js";
import lume from "https://deno.land/x/lume/mod.js";

const site = lume();

// Ignore repo files that aren't part of the site
site.ignore("README.md", "vscode.code-workspace")

// Copy the images and other static things
site.copy("static/favicon", "/")
site.copy("static")

site.use(css({ map: true }));

export default site;