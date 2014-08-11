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
var isDevelBuild = gutil.env.type !== "production";

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

gulp.task("setWatch", function () {
    global.isWatching = true;
});

gulp.task("browserify", function () {
    var bundler = (global.isWatching ? watchify : browserify)({
            entries: ["./client/app.js"],
            extensions: [".js", ".json"],
            debug: isDevelBuild
        }).
        transform(envify);

    var bundle = function () {
        console.log("bundling", Date.now());

        return bundler.bundle().
            on("error", handleError).
            pipe(source("app.js")).
            pipe(gulpif(! isDevelBuild, streamify(uglify({
                preserveComments: "some",
                warnings: true
            })))).
            pipe(gulp.dest("./public/assets/js"));
    };

    if (global.isWatching) {
        bundler.on("update", bundle);
    }

    return bundle();
});

gulp.task("build", ["browserify"]);
gulp.task("watch", ["setWatch", "build"]);
gulp.task("default", ["build"]);
