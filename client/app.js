var debug = require("debug")("app.js");

var candidatePreview = /kuraattori\/[a-z0-9]+\/esikatsele/i;

function start() {
    debug("start");

    // TODO: add router triggers here

    if (candidatePreview.test(window.location)) {
        require("./preview");
    }
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
