var debug = require("debug")("app.js");
var page = require("page");

function domready(callback) {
    if (/interactive|complete/.test(document.readyState)) {
        callback();
    } else {
        document.addEventListener("DOMContentLoaded", callback);
    }
}

function start() {
    debug("start");

    // Define routes
    page("/kuraattori/:token/esikatsele", require("./preview").run);
    page("/kuraattori/:token/profiili", require("./profile").run);
    page("/kuraattori/:token/vinkatut", require("./hints").run);

    // Start router for dispatch
    page.start({
        click: false,
        popstate: false,
        hashbang: false
    });
}

if (process.env.NODE_ENV !== "production") {
    // Enable all debug output
    require("debug").enable("*");
}

domready(start);
