var debug = require("debug")("app.js");

function start() {
    debug("start");
    // TODO: add router triggers here
}

if (process.env.NODE_ENV !== "production") {
    // Enable all debug output
    require("debug").enable("*");
}

if (/interactive|complete/.test(document.readyState)) {
    start();
} else {
    document.addEventListener("DOMContentLoaded", start);
}
