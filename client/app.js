var debug = require("debug")("app.js");

var candidatePreview = /kuraattori\/[a-z0-9]+\/esikatsele/i;
var profileEdit = /kuraattori\/[a-z0-9]+\/profiili/i;

function domready(callback) {
    if (/interactive|complete/.test(document.readyState)) {
        callback();
    } else {
        document.addEventListener("DOMContentLoaded", callback);
    }
}

function start() {
    debug("start");

    // TODO: add router triggers here

    if (candidatePreview.test(window.location)) {
        require("./preview");
    } else if (profileEdit.test(window.location)) {
        require("./profile");
    }
}

if (process.env.NODE_ENV !== "production") {
    // Enable all debug output
    require("debug").enable("*");
}

domready(start);
