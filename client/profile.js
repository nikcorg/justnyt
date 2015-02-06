var debug = require("debug")("preview");
var Bacon = require("baconjs");
var compose = require("funcalicious/compose");
var request = require("superagent");
var Promise = require("bluebird");
var form;

var ERR_ALIAS_RESERVED = 1;
var ERR_ALIAS_EMAIL_MISMATCH = 2;
var ERR_ALIAS_RESERVED_OR_EMAIL_MISMATCH = 3;

function isValidAlias(alias) {
    return alias.length > 0 && alias;
}

function isValidEmail(email) {
    return /^[^@]+@([^.]+\.)+([a-z]{2,})$/.test(email);
}

function toBool(v) {
    return !!v;
}

function identity(val) {
    return val;
}

function eventTargetValue(ev) {
    return ev.target.value;
}


function updateInputIfEmpty(input, value) {
    if (input.value == "" && value) {
        input.value = value;
    }
}

function raiseFormError(err) {
    switch (err) {
        case ERR_ALIAS_RESERVED:
            form.flashErrorMessage("Valitsemasi nimimerkki on varattu. Täytä sähköpostikenttä tai vaihda nimimerkkiä.");
            break;

        case ERR_ALIAS_EMAIL_MISMATCH:
            form.flashErrorMessage("Antamasi sähköpostiosoite ei täsmää varattuun nimimerkkiin.");
            break;

        case ERR_ALIAS_RESERVED_OR_EMAIL_MISMATCH:
            form.flashErrorMessage("Valitsemasi nimimerkki on varattu. Tarkista sähköpostiosoite.");
            break;
    }
}

function fetchProfile(filter) {
    return new Promise(function (resolve, reject) {
        request.get("/profiles?" + filter).
        set("Accept", "application/json").
        end(function (resp) {
            if (resp.error) {
                return reject(resp.error);
            }

            resolve(resp.body.Profiles || []);
        });
    });
}

function fetchProfileByEmail(email) {
    debug("fetch by email", email);
    return fetchProfile("email=" + encodeURIComponent(email)).
    then(function (profiles) {
        return profiles.length === 1 ? profiles.pop() : null;
    }).
    then(function (profile) {
        debug("fetched", profile);
        return profile;
    });
}

function fetchProfilesByAlias(alias) {
    debug("fetch by alias", alias);
    return fetchProfile("alias=" + encodeURIComponent(alias)).
    then(function (profiles) {
        debug("fetched", profiles);
        return profiles;
    });
}

function run() {
    form = require("./form-tools")(document.querySelector("#profile-form"));

    var alias = Bacon.fromEventTarget(form.findInput("alias"), "change").
        merge(
            Bacon.fromEventTarget(form.findInput("alias"), "keyup")
        ).
        map(eventTargetValue).
        skipDuplicates().
        toProperty(form.findInput("alias").value);

    var email = Bacon.fromEventTarget(form.findInput("email"), "change").
        merge(
            Bacon.fromEventTarget(form.findInput("email"), "keyup")
        ).
        map(eventTargetValue).
        skipDuplicates().
        toProperty(form.findInput("email").value);

    var aliasProfiles = alias.
        debounce(600).
        filter(isValidAlias).
        flatMapLatest(compose(fetchProfilesByAlias, Bacon.fromPromise.bind(Bacon))).
        toProperty(null);

    var emailProfile = email.
        debounce(600).
        filter(isValidEmail).
        flatMapLatest(compose(fetchProfileByEmail, Bacon.fromPromise.bind(Bacon))).
        toProperty(null);

    var validEmail = email.map(isValidEmail).map(toBool).flatMap(function (v) {
        return v ? emailProfile : null;
    });

    var validAlias = alias.map(isValidAlias).map(toBool).flatMap(function (v) {
        return v ? aliasProfiles : null;
    });

    var aliasIsReserved = validAlias.flatMap(function (profiles) {
            return Array.isArray(profiles) && profiles.some(function (profile) {
                return parseInt(profile.Reserved, 10) === 1;
            });
        }).
        toProperty(false);

    var emailMatchesAlias = Bacon.combineTemplate({
            reserved: aliasIsReserved,
            aliases: validAlias,
            email: validEmail
        }).
        changes().
        debounce(600).
        map(function (props) {
            var reserved = props.reserved;
            var aliasProfiles = props.aliases;
            var emailProfile = props.email;

            var val = !reserved || (emailProfile && aliasProfiles && Array.isArray(aliasProfiles) && aliasProfiles.some(function (profile) {
                return profile.ProfileId === emailProfile.ProfileId;
            }));

            return val;
        }).
        map(toBool);

    emailMatchesAlias.not().onValue(function (v) {
        if (v) {
            debug("email/alias mismatch", v);
            raiseFormError(ERR_ALIAS_RESERVED_OR_EMAIL_MISMATCH);
        } else {
            debug("email matches alias or alias is unreserved", v);
            form.clearErrorMessages();
        }

        form.node.querySelector("button").disabled = v;
    });

    emailProfile.filter(identity).onValue(function (profile) {
        updateInputIfEmpty(form.findInput("alias"), profile.Alias);
        updateInputIfEmpty(form.findInput("description"), profile.Description);
        updateInputIfEmpty(form.findInput("homepage"), profile.Homepage);
    });
}

module.exports = run.run = run;
