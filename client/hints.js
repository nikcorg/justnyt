var debug = require("debug")("client:hints");
var request = require("superagent");
var Promise = require("bluebird");

function doDelete(url) {
    return new Promise(function (resolve, reject) {
        request.del(url).
        set("Accept", "application/json").
        end(function (resp) {
            if (resp.error) {
                return reject(resp.error);
            }

            resolve(resp.body);
        });
    });
}

function onDeleteClicked(evt) {
    var node = evt.currentTarget || evt.target;

    evt.preventDefault();

    doDelete(node.href).
    then(function (resp) {
        // FIXME: markup hierarchy should not be embedded in handler
        node.parentNode.parentNode.removeChild(node.parentNode);
    }).
    catch(function (err) {
        // TODO: show feedback in UI
        debug(err);
    });
}

function init(nodes) {
    nodes.forEach(function (aNode) {
        aNode.addEventListener("click", onDeleteClicked, false);
        aNode.classList.remove("hidden");
    });
}

init([].slice.call(document.querySelectorAll("a[data-action=delete]"), 0));

module.exports = {};
