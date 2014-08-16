var debug = require("debug")("preview");
var Bacon = require("baconjs");
var funz = require("funz");
var request = require("superagent");
var Promise = require("bluebird");
var form = require("./form-tools")(document.querySelector("#profile-form"));

var ERR_ALIAS_RESERVED = 1;
var ERR_ALIAS_EMAIL_MISMATCH = 2;
var ERR_ALIAS_RESERVED_OR_EMAIL_MISMATCH = 3;

function validAlias(alias) {
    return alias.length > 0 && alias;
}

function validEmail(email) {
    return /^[^@]+@([^.]+\.)+([a-z]{2,})$/.test(email);
}

function toBool(v) {
    return !!v;
}

function identity(val) {
    return val;
}

var alias = Bacon.fromEventTarget(form.findInput("alias"), "change").
    merge(
        Bacon.fromEventTarget(form.findInput("alias"), "keyup")
    ).
    map(".target").
    map(".value").
    skipDuplicates().
    toProperty(form.findInput("alias").value);

var email = Bacon.fromEventTarget(form.findInput("email"), "change").
    merge(
        Bacon.fromEventTarget(form.findInput("email"), "keyup")
    ).
    map(".target").
    map(".value").
    skipDuplicates().
    toProperty(form.findInput("email").value);

var aliasProfiles = alias.
    debounce(600).
    filter(validAlias).
    flatMapLatest(funz.compose(Bacon.fromPromise.bind(Bacon), fetchProfilesByAlias)).
    toProperty(null);

var emailProfile = email.
    debounce(600).
    filter(validEmail).
    flatMapLatest(funz.compose(Bacon.fromPromise.bind(Bacon), fetchProfileByEmail)).
    toProperty(null);

var aliasIsReserved = aliasProfiles.filter(identity).flatMap(function (profiles) {
        return profiles.some(function (profile) {
            return parseInt(profile.Reserved, 10) === 1;
        });
    }).
    toProperty(false);

var emailMatchesAlias = Bacon.combineTemplate({
        reserved: aliasIsReserved,
        aliases: aliasProfiles,
        email: emailProfile
    }).
    changes().
    map(function (props) {
        var reserved = props.reserved;
        var aliasProfiles = props.aliases;
        var emailProfile = props.email;

        var val = !reserved || aliasProfiles && emailProfile && aliasProfiles.some(function (profile) {
            return profile.ProfileId === emailProfile.ProfileId;
        });

        return val;
    }).
    map(toBool);

var aliasHasValue = alias.changes().map(toBool);
var emailHasValue = email.changes().map(toBool);

/*
    if alias has value and email is empty and alias is reserved: ERR_ALIAS_RESERVED
*/
var aliasReservedErr = aliasHasValue.
        toProperty(false).
        and(emailHasValue.not().toProperty(true)).
        and(aliasIsReserved);

/*
    if alias has value and email has value and not email matches alias: ERR_ALIAS_EMAIL_MISMATCH
 */
var aliasEmailMismatchErr = aliasHasValue.
        toProperty(false).
        and(emailHasValue.toProperty(false)).
        and(emailMatchesAlias.not());

// alias.onValue(form.clearErrorMessages);
// email.onValue(form.clearErrorMessages);

// aliasReservedErr.or(aliasEmailMismatchErr).changes().onValue(function (v) {
//     if (! v) {
//         form.clearErrorMessages();
//     }
// });

// aliasReservedErr.onValue(function (v) {
//     debug("alias reserved err", v);
//     if (v) {
//         raiseFormError(ERR_ALIAS_RESERVED);
//     }
// });

// aliasEmailMismatchErr.onValue(function (v) {
//     debug("alias/email mismatch err", v);
//     if (v) {
//         raiseFormError(ERR_ALIAS_EMAIL_MISMATCH);
//     }
// });

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

module.exports = {};
