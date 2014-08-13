var browserify = require("browserify");
var envify = require("envify");
var gulp = require("gulp");
var gulpif = require("gulp-if");
var gutil = require("gulp-util");
var notify = require("gulp-notify");
var Promise = require("bluebird");
var rimraf = require("rimraf");
var source = require("vinyl-source-stream");
var streamify = require("gulp-streamify");
var uglify = require("gulp-uglify");
var watchify = require("watchify");
var eventStream = require("event-stream");
var isDevelBuild = global.isDevelBuild = gutil.env.type !== "production";

function handleError(err) {
    notify.onError({
        title: "Bundle compilation failed",
        message: "<%= error.message %>"
    }).apply(this, Array.prototype.slice.call(arguments, 0));

    this.emit("end");
}

gulp.task("clean", function () {
    return new Promise(function (resolve, reject) {
        rimraf("./public/assets/js", function (err) {
            if (err) {
                return reject(err);
            }

            resolve.apply(null, arguments);
        });
    });
});

gulp.task("browserify", function () {
    var bundles = {
        app: {
            src: "./client/app.js",
            dest: "./public/assets/js",
            filename: "app.js"
        },
        global: {
            src: "./client/global.js",
            dest: "./public/assets/js",
            filename: "global.js"
        }
    };

    var bundlers = Object.keys(bundles).map(function (key) {
        var opts = bundles[key];
        var bundler = (global.isDevelBuild ? watchify : browserify)({
                entries: [opts.src],
                extensions: [".js", ".json"],
                debug: isDevelBuild
            }).
            transform(envify);

        function bundle() {
            console.log(new Date(), "bundling", key);

            return bundler.bundle().
                on("error", handleError).
                pipe(source(opts.filename)).
                pipe(gulpif(! isDevelBuild, streamify(uglify({
                    preserveComments: "some",
                    warnings: true
                })))).
                pipe(gulp.dest(opts.dest));
        }

        if (global.isDevelBuild) {
            bundler.on("update", bundle);
        }

        return bundle();
    });

    return eventStream.merge.apply(eventStream, bundlers);
});

gulp.task("build", ["browserify"]);
gulp.task("default", ["build"]);
