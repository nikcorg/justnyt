var debug = require("debug")("preview");
var request = require("superagent");
var Promise = require("bluebird");
var form;

function setBlocker() {
    document.querySelector(".form-blocker").classList.remove("hidden");
}

function clearBlocker() {
    document.querySelector(".form-blocker").classList.add("hidden");
}

function updateForm(data) {
    form.querySelector("input[name=title]").value = data.Title;
}

function fetchPreview() {
    return new Promise(function (resolve, reject) {
        request.get(form.getAttribute("action").replace(/\/suosittelut\//, "/scrape/")).
        set("Accept", "application/json").
        end(function (resp) {
            if (resp.error) {
                return reject(resp.error);
            }

            resolve(resp.body);
        });
    });
}

function run() {
    form = document.querySelector("#preview-form");

    if (form) {
        setBlocker();

        fetchPreview().
        then(updateForm).
        finally(clearBlocker);
    }
}

module.exports = run.run = run;
